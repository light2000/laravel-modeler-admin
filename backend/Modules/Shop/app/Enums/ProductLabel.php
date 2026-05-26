<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Enums\Concerns\ProductLabelExt中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Enums;

use Modules\Shop\Enums\Concerns\ProductLabelExt;

enum ProductLabel:string
{
    use ProductLabelExt;
    case BestSeller = 'best_seller';
    case New = 'new';
    case Recommend = 'recommend';
    case Promotion = 'promotion';

    public function label(): string
    {
        return $this->extLabel() ?? $this->defaultLabel();
    }

    public function defaultLabel(): string
    {
        return match($this) {
            self::BestSeller     => "热卖",
            self::New     => "新品",
            self::Recommend     => "推荐",
            self::Promotion     => "促销",
        };
    }
}
