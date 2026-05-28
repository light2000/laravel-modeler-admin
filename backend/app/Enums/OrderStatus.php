<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在App\Enums\Concerns\OrderStatusExt中编写。
|--------------------------------------------------------------------------
*/
namespace App\Enums;

use App\Enums\Concerns\OrderStatusExt;

enum OrderStatus:string
{
    use OrderStatusExt;
    case Pending = 'pending';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return $this->extLabel() ?? $this->defaultLabel();
    }

    public function defaultLabel(): string
    {
        return match($this) {
            self::Pending     => "待支付",
            self::Paid     => "已支付",
            self::Shipped     => "已发货",
            self::Completed     => "已完成",
            self::Cancelled     => "已取消",
        };
    }
}
