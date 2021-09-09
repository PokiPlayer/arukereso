<?php

declare(strict_types=1);

namespace App\Contracts\Enum;

interface EnumInterface
{

    /**
     * @return int|string
     */
    public function getValue();

    /**
     * @param $value
     *
     * @return EnumInterface
     */
    public static function create($value): EnumInterface;

    /**
     * @param $const
     *
     * @return bool
     */
    public static function checkConstant($const): bool;

    /**
     * @param $const
     *
     * @return bool
     */
    public static function hasConstant($const): bool;

    /**
     * @return array
     */
    public static function getEnumValues(): array;

    /**
     * @param EnumInterface $to
     *
     * @return bool
     */
    public function isEquals(EnumInterface $to): bool;

    /**
     * @param EnumInterface $to
     *
     * @return bool
     */
    public function is(EnumInterface $to): bool;

    /**
     * @param mixed $to
     *
     * @return bool
     */
    public function isValue($to): bool;
}
