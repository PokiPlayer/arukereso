<?php

declare(strict_types=1);

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Database\Eloquent\Casts\Order\DeliveryModeCast;
use App\Database\Eloquent\Casts\Order\OrderStatusCast;
use App\Enum\Order\DeliveryModeEnum;
use App\Enum\Order\OrderStatusEnum;
use App\Models\User;

/**
 * @property int                    $id
 * @property int                    $user_id
 * @property string                 $customer_name
 * @property string                 $customer_email
 * @property DeliveryModeEnum       $delivery_mode
 * @property OrderStatusEnum        $order_status
 * @property User                   $user
 * @property Collection|OrderItem[] $items
 * @property OrderBillingAddress    $billingAddress
 * @property OrderShippingAddress   $shippingAddress
 */
class Order extends Model
{
    public const TABLE_NAME       = 'orders';
    public const FOREIGN_KEY_NAME = 'order_id';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        User::FOREIGN_KEY_NAME,
        'customer_name',
        'customer_email',
        'delivery_mode',
        'order_status',
    ];

    protected $casts = [
        'delivery_mode' => DeliveryModeCast::class,
        'order_status'  => OrderStatusCast::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function billingAddress()
    {
        return $this->hasOne(OrderBillingAddress::class, self::FOREIGN_KEY_NAME, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shippingAddress()
    {
        return $this->hasOne(OrderShippingAddress::class, self::FOREIGN_KEY_NAME, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, self::FOREIGN_KEY_NAME, 'id');
    }
}
