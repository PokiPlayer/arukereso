<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Contracts\Repositories\Product\ProductRepositoryInterface;
use App\Models\Product\Product;
use App\Repositories\ModelRepository;

class ProductRepository extends ModelRepository implements ProductRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
