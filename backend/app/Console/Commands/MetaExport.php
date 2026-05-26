<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Nwidart\Modules\Facades\Module;

#[Signature('app:meta-export')]
#[Description('Export system meta definitions (permissions, enums)')]
class MetaExport extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $frontMetaPath = dirname(base_path()) . '/admin/src/meta';
        //从所有Module的config目录中permissions.php文件获取当前Module的所有权限
        $permissionMeta = collect(Module::all())->map(fn($module) => config($module->getSnakeName() . '.permissions'))->filter()->values();

        //遍历所有Module的app/Enums目录，获取所有枚举配置
        $enumMeta = collect(Module::all())
            ->flatMap(function ($module) {
                $enumPath = $module->getPath() . '/app/Enums';
                if (!File::isDirectory($enumPath)) {
                    return [];
                }
                $namespace = 'Modules\\' . $module->getName() . '\\Enums\\';

                return collect(File::files($enumPath))
                    ->map(fn($file) => $namespace . $file->getFilenameWithoutExtension())
                    ->filter(fn($class) => enum_exists($class));
            })
            ->mapWithKeys(function ($enumClass) {
                $enumKey = Str::snake(class_basename($enumClass));
                $enumItems = collect($enumClass::cases())
                    ->map(function ($case) {
                        $label = method_exists($case, 'label') ? $case->label() : $case->name;
                        return ['value' => $case->value, 'label' => $label];
                    })
                    ->values();

                return [$enumKey => $enumItems];
            });

        //遍历app/Enums，获取枚举配置
        $enumPath = app_path('/Enums');
        if (File::isDirectory($enumPath)) {
            $namespace = 'App\\Enums\\';

            $appEnums = collect(File::files($enumPath))
                ->map(fn($file) => $namespace . $file->getFilenameWithoutExtension())
                ->filter(fn($class) => enum_exists($class))->mapWithKeys(function ($enumClass) {
                    $enumKey = Str::snake(class_basename($enumClass));
                    $enumItems = collect($enumClass::cases())
                        ->map(function ($case) {
                            $label = method_exists($case, 'label') ? $case->label() : $case->name;
                            return ['value' => $case->value, 'label' => $label];
                        })
                        ->values();

                    return [$enumKey => $enumItems];
                });
            ;
            $enumMeta = $enumMeta->merge($appEnums);
        }

        //生成JSON配置到前端代码包，供前端使用
        $this->info('Exporting permission meta to ' . $frontMetaPath . '/permissions.json');
        $this->info('Exporting enum meta to ' . $frontMetaPath . '/enums.json');

        File::put($frontMetaPath . '/permissions.json', $permissionMeta->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        File::put($frontMetaPath . '/enums.json', $enumMeta->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        //将新增的权限添加到permissions表，方便spatie/laravel-permission使用
        $this->info('Checking and creating missing permissions in permissions table...');
        $actionKeys = [];
        foreach ($permissionMeta as $module) {
            if (empty($module['children']) || !is_array($module['children'])) {
                continue;
            }
            foreach ($module['children'] as $child) {
                if (empty($child['actions']) || !is_array($child['actions'])) {
                    continue;
                }
                foreach ($child['actions'] as $action) {
                    if (!empty($action['key'])) {
                        $actionKeys[] = $action['key'];
                    }
                }
            }
        }
        $actionKeys = array_values(array_unique($actionKeys));
        if (!empty($actionKeys)) {
            $existingNames = Permission::query()
                ->whereIn('name', $actionKeys)
                ->pluck('name')
                ->all();
            $existingLookup = array_flip($existingNames);

            foreach ($actionKeys as $key) {
                if (isset($existingLookup[$key])) {
                    continue;
                }
                Permission::firstOrCreate(['name' => $key], ['guard_name' => 'administrator']);
            }
        }

        $this->info('Export completed');
    }
}
