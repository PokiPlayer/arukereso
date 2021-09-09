<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

interface PersistableRepositoryInterface extends RepositoryInterface
{

    /**
     * @return Model
     */
    public function createModel(): Model;

    /**
     * @param Model $model
     *
     * @return Model
     */
    public function save(Model $model): Model;

    /**
     * @param callable $callable
     */
    public function transactional(callable $callable);
}
