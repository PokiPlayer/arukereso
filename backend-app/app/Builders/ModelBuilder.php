<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Builders\ModelBuilderInterface;

abstract class ModelBuilder implements ModelBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function build($buildBy, ?Model $model = null): Model {
        if (!$this->isSupported($buildBy)) {
            throw new \InvalidArgumentException(sprintf('Not supported to build model by argument!'));
        }

        return $this->doBuild($buildBy, $model);
    }

    /**
     * @param mixed $buildBy
     *
     * @return bool
     */
    abstract protected function isSupported($buildBy): bool;

    /**
     * @param            $buildBy
     * @param Model|null $model
     *
     * @return Model
     */
    abstract protected function doBuild($buildBy, ?Model $model = null): Model;
}
