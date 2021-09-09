<?php

declare(strict_types=1);

namespace App\Enum;

use App\Contracts\Enum\EnumInterface;
use APP\Exceptions\NotFoundException;

abstract class Enum implements EnumInterface
{
    /**
     * @var int|string
     */
    protected $value;

    /**
     * @var array
     */
    protected static $cache = [];

    /**
     * @var array
     */
    protected static $objectCache = [];

    /**
     * @param mixed $value
     *
     * @throws NotFoundException
     */
    public function __construct($value) {
        self::checkConstant($value);
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public static function create($value): EnumInterface
    {
        $class = get_called_class();
        if (!isset(static::$objectCache[$class][$value])) {
            static::$objectCache[$class][$value] = new $class($value);
        }

        return static::$objectCache[$class][$value];
    }

    /**
     * @param $const
     * @return bool
     * @throws NotFoundException
     */
    public static function checkConstant($const): bool {
        if (self::hasConstant($const)) {
            return true;
        }
        throw new NotFoundException(sprintf(
            'Constant value not found: %s in enum class: %s',
            $const,
            get_called_class()
        ));
    }

    /**
     * @inheritdoc
     */
    public static function hasConstant($const): bool {
        return in_array($const, self::getConstants(), true);
    }

    /**
     * @inheritdoc
     */
    public static function getEnumValues(): array {
        return array_values(self::getConstants());
    }

    /**
     * @inheritdoc
     */
    public function isEquals(EnumInterface $to): bool {
        return ($this === $to) && $this->is($to);
    }

    /**
     * @inheritdoc
     */
    public function is(EnumInterface $to): bool {
        return ($this->getValue() === $to->getValue());
    }

    /**
     * {@inheritDoc}
     */
    public function isValue($to): bool {
        return $to === $this->getValue();
    }

    /**
     * @return array
     */
    protected static function getConstants(): array {
        $class = get_called_class();
        if (!isset(static::$cache[$class])) {
            static::$cache[$class] = (new \ReflectionClass($class))->getConstants();
        }

        return static::$cache[$class];
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return (string)$this->getValue();
    }
}
