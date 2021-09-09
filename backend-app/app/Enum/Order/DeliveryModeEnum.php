<?php

declare(strict_types=1);

namespace App\Enum\Order;

use App\Enum\Enum;

class DeliveryModeEnum extends Enum
{
    public const SHIPPING = 'shipping';
    public const PERSONAL = 'personal';
}
