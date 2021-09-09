<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use Illuminate\Http\JsonResponse;
use App\Handlers\Order\OrderHttpSearchHandler;
use App\Http\Resources\OrderListItemResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderListRequest;

class OrderListController extends Controller
{
    protected OrderHttpSearchHandler $handler;

    /**
     * @param OrderHttpSearchHandler $handler
     */
    public function __construct(OrderHttpSearchHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param OrderListRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(OrderListRequest $request): JsonResponse {
        $collection = $this->handler->handle($request);

        return OrderListItemResource::collection($collection)->response();
    }
}
