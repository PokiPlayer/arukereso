<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use App\Contracts\Repositories\Order\OrderBillingAddressRepositoryInterface;
use App\Models\Order\OrderBillingAddress;
use App\Repositories\ModelPersistableRepository;

class OrderBillingAddressRepository extends ModelPersistableRepository implements OrderBillingAddressRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(OrderBillingAddress $model)
    {
        parent::__construct($model);
    }
}
