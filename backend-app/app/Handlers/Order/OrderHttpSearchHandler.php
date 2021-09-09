<?php

declare(strict_types=1);

namespace App\Handlers\Order;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Contracts\Repositories\Order\OrderRepositoryInterface;
use App\Http\Requests\Order\OrderListRequest;

class OrderHttpSearchHandler
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
     * @param OrderListRequest $request
     *
     * @return Collection
     */
    public function handle(OrderListRequest $request): Collection
    {
        $criterias = $request->all();
        $builder   = $this->repository->getBuilder();
        $this->addUserCriteria($criterias, $builder);
        $this->addOrderIdCriteria($criterias, $builder);
        $this->addOrderStatusCriteria($criterias, $builder);
        $this->addFromToCriteria($criterias, $builder);

        return $builder->get();
    }

    /**
     * @param array   $criterias
     * @param Builder $builder
     */
    protected function addUserCriteria(array $criterias, Builder $builder): void
    {
        if (isset($criterias[OrderListRequest::FIELD_USER])) {
            $builder->where(User::FOREIGN_KEY_NAME, '=', $criterias[OrderListRequest::FIELD_USER]);
        }
    }

    /**
     * @param OrderListRequest $request
     * @param Builder          $builder
     */
    protected function addOrderIdCriteria(array $criterias, Builder $builder): void
    {
        if (isset($criterias[OrderListRequest::FIELD_ID])) {
            $builder->where('id', '=', $criterias[OrderListRequest::FIELD_ID]);
        }
    }

    /**
     * @param array   $criterias
     * @param Builder $builder
     */
    protected function addOrderStatusCriteria(array $criterias, Builder $builder): void
    {
        if (isset($criterias[OrderListRequest::FIELD_STATUS])) {
            $builder->where('order_status', $criterias[OrderListRequest::FIELD_STATUS]);
        }
    }

    /**
     * @param array   $criterias
     * @param Builder $builder
     */
    protected function addFromToCriteria(array $criterias, Builder $builder): void
    {
        if (isset($criterias[OrderListRequest::FIELD_CREATED_FROM])) {
            $builder->where('created_at', '>=', $criterias[OrderListRequest::FIELD_CREATED_FROM]);
        }

        $builder->where('created_at', '<=', $criterias[OrderListRequest::FIELD_CREATED_TO]);
    }
}
