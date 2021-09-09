<?php

declare(strict_types=1);

namespace App\Contracts\Builders;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\NotFoundException;

interface ModelBuilderInterface
{
    /**
     * @param mixed      $buildBy
     * @param Model|null $model
     *
     * @return Model
     *
     * @throws \InvalidArgumentException
     * @throws NotFoundException
     */
    public function build($buildBy, ?Model $model = null): Model;
}
