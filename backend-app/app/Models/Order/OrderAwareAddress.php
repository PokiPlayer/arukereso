<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Models\Address;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $order_id
 */
abstract class OrderAwareAddress extends Address
{
    use SoftDeletes;

    protected $fillable = [
        Order::FOREIGN_KEY_NAME,
        'city',
        'postcode',
        'address',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, Order::FOREIGN_KEY_NAME);
    }
}
