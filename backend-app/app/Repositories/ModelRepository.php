<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\RepositoryInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

abstract class ModelRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $modelClass;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model      = $model;
        $this->modelClass = get_class($model);
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): Collection
    {
        return $this->model->newQuery()->get();
    }

    /**
     * @inheritDoc
     */
    public function findById($id, bool $withTrashed = false, array $relations = []): Model {
        try {
            return $this->model->newQuery()
                ->when($withTrashed, function (Builder $query) use ($relations) {
                    $query->withTrashed();
                })
                ->where('id', $id)
                ->when([] !== $relations, function (Builder $query) use ($relations) {
                    $query->with($relations);
                })
                ->firstOrFail();
        } catch(ModelNotFoundException $e) {
            throw new NotFoundException(sprintf('Not found model: "%s" by id: "%s"', $this->getModelClass(), $id), 0, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function getBuilder(): Builder
    {
        return $this->model->newQuery();
    }
}
