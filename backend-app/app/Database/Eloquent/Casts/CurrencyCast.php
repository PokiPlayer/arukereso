<?php

declare(strict_types=1);

namespace App\Database\Eloquent\Casts;

use App\Contracts\Database\Eloquent\Casts\EnumerationCast;
use App\Enum\CurrencyEnum;

class CurrencyCast extends EnumerationCast
{
    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return CurrencyEnum::class;
    }
}
