<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use App\Builders\Order\OrderModelByArrayBuilder;
use App\Models\User;
use App\Builders\Order\OrderBillingAddressModelBuilder;
use App\Builders\Order\OrderShippingAddressModelBuilder;
use App\Models\Order\OrderBillingAddress;
use App\Models\Order\OrderShippingAddress;
use App\Builders\Order\OrderItemModelByArrayBuilder;
use App\Handlers\Order\OrderStoreHandler;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;

class OrderStoreController extends Controller
{
    protected OrderModelByArrayBuilder         $orderBuilder;
    protected OrderItemModelByArrayBuilder     $itemBuilder;
    protected OrderShippingAddressModelBuilder $shippingAddressBuilder;
    protected OrderBillingAddressModelBuilder  $billingAddressBuilder;
    protected OrderStoreHandler                $handler;

    /**
     * @param OrderModelByArrayBuilder         $orderBuilder
     * @param OrderItemModelByArrayBuilder     $itemBuilder
     * @param OrderShippingAddressModelBuilder $shippingAddressBuilder
     * @param OrderBillingAddressModelBuilder  $billingAddressBuilder
     * @param OrderStoreHandler                $handler
     */
    public function __construct(
        OrderModelByArrayBuilder $orderBuilder,
        OrderItemModelByArrayBuilder $itemBuilder,
        OrderShippingAddressModelBuilder $shippingAddressBuilder,
        OrderBillingAddressModelBuilder $billingAddressBuilder,
        OrderStoreHandler $handler
    ) {
        $this->orderBuilder           = $orderBuilder;
        $this->itemBuilder            = $itemBuilder;
        $this->shippingAddressBuilder = $shippingAddressBuilder;
        $this->billingAddressBuilder  = $billingAddressBuilder;
        $this->handler                = $handler;
    }

    /**
     * @param OrderStoreRequest $request
     *
     * @return JsonResponse
     * @throws \App\Exceptions\NotFoundException
     */
    public function __invoke(OrderStoreRequest $request): JsonResponse
    {
        /** @var Order $orderModel */
        /** @var OrderItem[] $orderItemModels */
        /** @var OrderBillingAddress $orderBillingModel */
        /** @var OrderShippingAddress|NULL $orderShippingModel */
        /** @var User|NULL $currentUser */

        $currentUser       = Auth::user();
        $data              = $request->all();
        $orderModel        = $this->orderBuilder->build($data);
        $orderBillingModel = $this->billingAddressBuilder->build($data[OrderStoreRequest::FIELD_BILLING_ADDRESS]);

        $orderShippingModel = null;
        if (isset($data[OrderStoreRequest::FIELD_SHIPPING_ADDRESS])) {
            $orderShippingModel = $this->shippingAddressBuilder->build(
                $data[OrderStoreRequest::FIELD_SHIPPING_ADDRESS]
            );
        }

        $orderItemModels = new Collection();
        foreach ($data[OrderStoreRequest::FIELD_ITEMS] as $item) {
            $orderItemModels->add($this->itemBuilder->build($item));
        }

        try {
            $this->handler->handle(
                $orderModel,
                $orderItemModels,
                $orderBillingModel,
                $orderShippingModel,
                $currentUser
            );
        } catch (\Exception $e) {
            return response()->json(['Order failed!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([$orderModel->id]);
    }
}
