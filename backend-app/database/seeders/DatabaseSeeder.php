<?php

namespace Database\Seeders;

use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**0
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(2)->create();
        Product::factory(10)->create()->each(function ($product){
            $productPrice = ProductPrice::factory()->create([
                Product::FOREIGN_KEY_NAME => $product,
            ]);
        });
    }
}
