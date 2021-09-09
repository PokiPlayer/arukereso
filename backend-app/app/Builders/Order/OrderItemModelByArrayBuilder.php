<?php

declare(strict_types=1);

namespace App\Builders\Order;

use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Utils\PriceCalculatorHelper;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\OrderItem;

class OrderItemModelByArrayBuilder extends OrderItemModelBuilder
{
    /**
     * @inheritDoc
     */
    protected function isSupported($buildBy): bool
    {
        return is_array($buildBy);
    }

    /**
     * @inheritDoc
     */
    protected function doBuild($buildBy, ?Model $model = null): Model
    {
        /** @var array $buildBy */
        /** @var OrderItem $model */
        /** @var Product $product */
        /** @var ProductPrice $price */
        if (null === $model) {
            $model = $this->orderRepository->createModel();
        }
        $model->fill($buildBy);

        $product = $this->productRepository->findById($model->product_id);
        $price   = $product->price;

        $model->unit_net_price   = $price->net_price;
        $model->unit_gross_price = $price->gross_price;
        $model->tax              = $price->tax;
        $model->currency         = $price->currency;

        return $model;
    }
}
