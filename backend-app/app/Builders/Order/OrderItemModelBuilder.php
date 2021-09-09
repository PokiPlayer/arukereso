<?php

declare(strict_types=1);

namespace App\Builders\Order;

use App\Builders\ModelBuilder;
use App\Contracts\Builders\Order\OrderItemModelBuilderInterface;
use App\Contracts\Repositories\Order\OrderItemRepositoryInterface;
use App\Contracts\Repositories\Product\ProductRepositoryInterface;

abstract class OrderItemModelBuilder extends ModelBuilder implements OrderItemModelBuilderInterface
{
    protected OrderItemRepositoryInterface $orderRepository;
    protected ProductRepositoryInterface   $productRepository;

    /**
     * @param OrderItemRepositoryInterface $orderRepository
     * @param ProductRepositoryInterface   $productRepository
     */
    public function __construct(
        OrderItemRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository   = $orderRepository;
        $this->productRepository = $productRepository;
    }
}
