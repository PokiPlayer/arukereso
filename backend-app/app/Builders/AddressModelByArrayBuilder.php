<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Builders\AddressModelBuilderInterface;
use App\Contracts\Repositories\PersistableRepositoryInterface;
use App\Models\Address;

abstract class AddressModelByArrayBuilder extends ModelBuilder implements AddressModelBuilderInterface
{

    protected PersistableRepositoryInterface $repository;

    /**
     * @param PersistableRepositoryInterface $repository
     */
    public function __construct(PersistableRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    protected function isSupported($buildBy): bool
    {
        return is_array($buildBy);
    }

    /**
     * @inheritDoc
     */
    protected function doBuild($buildBy, ?Model $model = null): Model
    {
        /** @var Address $model */
        if (null === $model) {
            $model = $this->repository->createModel();
        }

        $model->fill($buildBy);

        return $model;
    }
}
