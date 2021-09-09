<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\PersistableRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class ModelPersistableRepository extends ModelRepository implements PersistableRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function createModel(): Model
    {
        $modelClass = $this->getModelClass();

        return new $modelClass();
    }

    /**
     * @inheritDoc
     */
    public function save(Model $model): Model
    {
        $model->save();

        return $model;
    }

    /**
     * @param callable $callable
     */
    public function transactional(callable $callable)
    {
        try {
            DB::beginTransaction();
            $result = $callable();
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
