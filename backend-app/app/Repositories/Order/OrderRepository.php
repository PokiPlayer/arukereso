<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use Illuminate\Support\Carbon;
use App\Models\Order\Order;
use App\Contracts\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\ModelPersistableRepository;

class OrderRepository extends ModelPersistableRepository implements OrderRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function findFirstOrderCreatedDate(): ?Carbon
    {
        $builder = $this->model->newQuery();
        $builder->orderBy('id', 'asc');
        $model = $builder->first();

        return NULL !== $model ? $model->created_at : NULL;
    }
}
