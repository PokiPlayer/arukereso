<?php

declare(strict_types=1);

namespace App\Http\Middleware\Order;

use Illuminate\Support\Facades\Auth;
use App\Contracts\Repositories\Order\OrderRepositoryInterface;
use App\Models\Order\Order;
use App\Models\User;

class OwnedOrder
{
    protected OrderRepositoryInterface $repository;

    /**
     * @param OrderRepositoryInterface $repository
     */
    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function handle($request, \Closure $next)
    {
        $orderId = $request->route()->parameter('id', null);
        /** @var User|null $user */
        $user = Auth::user();
        if (null === $user) {
            return response('Unauthorized', 401);
        }

        /** @var Order|null $order */
        $order = $this->repository->findById($orderId);
        if (null === $order) {
            return response('Not found order', 404);
        }

        if ($order->user_id === $user->id) {
            return $next($request);
        }

        return response('This order is not owned by current logged user', 403);
    }
}
