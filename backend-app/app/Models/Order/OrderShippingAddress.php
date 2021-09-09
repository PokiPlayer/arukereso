<?php

declare(strict_types=1);

namespace App\Models\Order;

class OrderShippingAddress extends OrderAwareAddress
{
    public const TABLE_NAME       = 'order_shipping_addresses';

    protected $table = self::TABLE_NAME;
}
