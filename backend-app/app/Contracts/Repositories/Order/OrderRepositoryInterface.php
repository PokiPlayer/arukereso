<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Order;

use Illuminate\Support\Carbon;
use App\Contracts\Repositories\PersistableRepositoryInterface;

interface OrderRepositoryInterface extends PersistableRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findFirstOrderCreatedDate(): ?Carbon;
}
