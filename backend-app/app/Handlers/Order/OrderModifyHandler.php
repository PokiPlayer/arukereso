<?php

declare(strict_types=1);

namespace App\Handlers\Order;

use App\Contracts\Repositories\Order\OrderRepositoryInterface;
use App\Models\Order\Order;

class OrderModifyHandler
{
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Order $model
     *
     * @return Order
     */
    public function handle(Order $model): Order {
        $this->orderRepository->save($model);

        return $model;
    }
}
