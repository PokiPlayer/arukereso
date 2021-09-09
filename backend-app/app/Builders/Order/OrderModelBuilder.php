<?php

declare(strict_types=1);

namespace App\Builders\Order;

use App\Builders\ModelBuilder;
use App\Contracts\Builders\Order\OrderModelBuilderInterface;
use App\Contracts\Repositories\Order\OrderRepositoryInterface;

abstract class OrderModelBuilder extends ModelBuilder implements OrderModelBuilderInterface
{
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
}
