<?php

declare(strict_types=1);

namespace App\Utils;

class PriceCalculatorHelper
{
    /**
     * @param float $netPrice
     * @param float $tax
     *
     * @return float
     */
    public static function calculateGrossByNetPriceAndTax(float $netPrice, float $tax): float {
        return round(($netPrice + ($tax * ($netPrice / 100))), 2);
    }
}
