<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends ModelRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
