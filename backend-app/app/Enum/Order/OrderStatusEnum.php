<?php

declare(strict_types=1);

namespace App\Enum\Order;

use App\Enum\Enum;

class OrderStatusEnum extends Enum
{
    public const NEW       = 'new';
    public const COMPLETED = 'completed';
}
