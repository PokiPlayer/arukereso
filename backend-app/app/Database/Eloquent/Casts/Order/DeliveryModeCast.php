<?php

declare(strict_types=1);

namespace App\Database\Eloquent\Casts\Order;

use App\Contracts\Database\Eloquent\Casts\EnumerationCast;
use App\Enum\Order\DeliveryModeEnum;

class DeliveryModeCast extends EnumerationCast
{
    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return DeliveryModeEnum::class;
    }
}
