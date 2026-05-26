<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Enums\Concerns\ProductStatusExt中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Enums;

use Modules\Shop\Enums\Concerns\ProductStatusExt;

enum ProductStatus:string
{
    use ProductStatusExt;
    case OnSale = 'on_sale';
    case OffSale = 'off_sale';

    public function label(): string
    {
        return $this->extLabel() ?? $this->defaultLabel();
    }

    public function defaultLabel(): string
    {
        return match($this) {
            self::OnSale     => "上架",
            self::OffSale     => "下架",
        };
    }
}
