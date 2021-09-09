<?php

declare(strict_types=1);

namespace App\Builders\Order;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order\Order;

class OrderModelByArrayBuilder extends OrderModelBuilder
{
    /**
     * @inheritDoc
     */
    protected function doBuild($buildBy, ?Model $model = null): Model
    {
        /** @var array $buildBy */
        /** @var Order $model */
        if (null === $model) {
            $model = $this->orderRepository->createModel();
        }

        $model->fill($buildBy);

        return $model;
    }

    /**
     * @param mixed $buildBy
     *
     * @return bool
     */
    protected function isSupported($buildBy): bool
    {
        return is_array($buildBy);
    }
}
