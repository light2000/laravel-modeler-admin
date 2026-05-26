<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在App\Enums\Concerns\UserStatusExt中编写。
|--------------------------------------------------------------------------
*/
namespace App\Enums;

use App\Enums\Concerns\UserStatusExt;

enum UserStatus:string
{
    use UserStatusExt;
    case Active = 'active';
    case Disabled = 'disabled';

    public function label(): string
    {
        return $this->extLabel() ?? $this->defaultLabel();
    }

    public function defaultLabel(): string
    {
        return match($this) {
            self::Active     => "正常",
            self::Disabled     => "禁用",
        };
    }
}
