<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Collection;

interface RepositoryInterface
{

    /**
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * @param mixed $id
     * @param bool  $withTrashed
     * @param array $relations
     *
     * @return Model
     * @throws NotFoundException
     */
    public function findById($id, bool $withTrashed = false, array $relations = []): Model;

    /**
     * @return Builder
     */
    public function getBuilder(): Builder;
}
