<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use App\Contracts\Repositories\Order\OrderItemRepositoryInterface;
use App\Models\Order\OrderItem;
use App\Repositories\ModelPersistableRepository;

class OrderitemRepository extends ModelPersistableRepository implements OrderItemRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(OrderItem $model)
    {
        parent::__construct($model);
    }
}
