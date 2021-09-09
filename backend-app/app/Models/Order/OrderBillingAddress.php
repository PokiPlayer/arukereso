<?php

declare(strict_types=1);

namespace App\Models\Order;

class OrderBillingAddress extends OrderAwareAddress
{
    public const TABLE_NAME       = 'order_billing_addresses';

    protected $table = self::TABLE_NAME;
}
