<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Order;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Contracts\Repositories\PersistableRepositoryInterface;

interface OrderBillingAddressRepositoryInterface extends AddressRepositoryInterface, PersistableRepositoryInterface
{

}
