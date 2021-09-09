<?php

declare(strict_types=1);

namespace App\Handlers\Order;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Contracts\Repositories\Order\OrderBillingAddressRepositoryInterface;
use App\Contracts\Repositories\Order\OrderItemRepositoryInterface;
use App\Contracts\Repositories\Order\OrderRepositoryInterface;
use App\Contracts\Repositories\Order\OrderShippingAddressRepositoryInterface;
use App\Models\Order\Order;
use App\Models\Order\OrderBillingAddress;
use App\Models\Order\OrderShippingAddress;

class OrderStoreHandler
{
    protected OrderRepositoryInterface                $orderRepository;
    protected OrderItemRepositoryInterface            $orderItemRepository;
    protected OrderBillingAddressRepositoryInterface  $billingAddressRepository;
    protected OrderShippingAddressRepositoryInterface $shippingAddressRepository;

    /**
     * @param OrderRepositoryInterface                $orderRepository
     * @param OrderItemRepositoryInterface            $orderItemRepository
     * @param OrderBillingAddressRepositoryInterface  $billingAddressRepository
     * @param OrderShippingAddressRepositoryInterface $shippingAddressRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        OrderBillingAddressRepositoryInterface $billingAddressRepository,
        OrderShippingAddressRepositoryInterface $shippingAddressRepository
    ) {
        $this->orderRepository           = $orderRepository;
        $this->orderItemRepository       = $orderItemRepository;
        $this->billingAddressRepository  = $billingAddressRepository;
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    /**
     * @param Order                     $orderModel
     * @param Collection                $orderItemModels
     * @param OrderBillingAddress       $orderBillingAddress
     * @param OrderShippingAddress|null $orderShippingAddress
     * @param User|null                 $user
     *
     * @return Order
     */
    public function handle(
        Order $orderModel,
        Collection $orderItemModels,
        OrderBillingAddress $orderBillingAddress,
        ?OrderShippingAddress $orderShippingAddress = null,
        ?User $user = null
    ): Order {
        $this->orderRepository->transactional(
            function () use ($orderModel, $orderItemModels, $orderBillingAddress, $orderShippingAddress, $user) {
                if (null !== $user) {
                    $orderModel->user_id = $user->id;
                }

                $this->orderRepository->save($orderModel);

                $orderBillingAddress->order_id = $orderModel->id;
                $this->billingAddressRepository->save($orderBillingAddress);

                if (null !== $orderShippingAddress) {
                    $orderShippingAddress->order_id = $orderModel->id;
                    $this->shippingAddressRepository->save($orderShippingAddress);
                }

                $orderItemModels = $orderItemModels->unique();
                foreach ($orderItemModels as $orderItemModel) {
                    $orderItemModel->order_id = $orderModel->id;
                    $this->orderItemRepository->save($orderItemModel);
                }
            }
        );

        return $orderModel;
    }
}
