<?php

declare(strict_types=1);

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enum\CurrencyEnum;
use App\Utils\PriceCalculatorHelper;
use App\Models\Product\ProductPrice;

class ProductPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $netPrice   = $this->faker->numberBetween(1000, 10000);
        $tax        = 27;
        $grossPrice = PriceCalculatorHelper::calculateGrossByNetPriceAndTax($netPrice, $tax);

        return [
            'net_price'   => $netPrice,
            'gross_price' => $grossPrice,
            'tax'         => $tax,
            'currency'    => CurrencyEnum::HUF,
        ];
    }
}
