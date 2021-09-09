<?php

declare(strict_types=1);

namespace App\Contracts\Database\Eloquent\Casts;

use App\Contracts\Enum\EnumInterface;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

abstract class EnumerationCast implements CastsAttributes
{
    /**
     * @return string
     */
    abstract protected function getEnumClass(): string;

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if (!isset($attributes[$key])) {
            return null;
        }

        /** @var EnumInterface $enumClass */
        $enumClass = $this::getEnumClass();
        return $enumClass::create($value);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return [$key => $value instanceof EnumInterface ? $value->getValue() : $value];
    }
}
