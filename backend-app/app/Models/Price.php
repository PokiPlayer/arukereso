<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Eloquent\Casts\CurrencyCast;
use App\Enum\CurrencyEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @property float        $net_price
 * @property float        $gross_price
 * @property float        $tax
 * @property CurrencyEnum $currency
 */
abstract class Price extends Model
{
    protected $casts = [
        'currency' => CurrencyCast::class,
    ];
}
