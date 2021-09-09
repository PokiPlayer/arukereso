<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Contracts\Repositories\Order\OrderRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderModifyRequest;
use App\Builders\Order\OrderModelByArrayBuilder;

class OrderModifyController extends Controller
{
    protected OrderModelByArrayBuilder $builder;
    protected OrderRepositoryInterface $repository;

    /**
     * @param OrderModelByArrayBuilder $builder
     * @param OrderRepositoryInterface $repository
     */
    public function __construct(OrderModelByArrayBuilder $builder, OrderRepositoryInterface $repository)
    {
        $this->builder    = $builder;
        $this->repository = $repository;
    }

    /**
     * @param OrderModifyRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(int $id, OrderModifyRequest $request): JsonResponse
    {
        try {
            $model = $this->repository->findById($id);
            $this->builder->build($request->all(), $model);
            $this->repository->save($model);
        } catch (\Exception $e) {
            return response()->json(['Order modify failed!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([$model->id]);
    }
}
