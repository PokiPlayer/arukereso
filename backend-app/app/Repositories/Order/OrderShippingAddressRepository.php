<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use App\Models\Order\OrderShippingAddress;
use App\Repositories\ModelPersistableRepository;
use App\Contracts\Repositories\Order\OrderShippingAddressRepositoryInterface;

class OrderShippingAddressRepository extends ModelPersistableRepository implements OrderShippingAddressRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(OrderShippingAddress $model)
    {
        parent::__construct($model);
    }
}
