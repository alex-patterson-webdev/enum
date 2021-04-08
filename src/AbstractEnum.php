<?php

declare(strict_types=1);

namespace Arp\Enum;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\Enum
 */
abstract class AbstractEnum implements EnumInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array<mixed>
     */
    private static array $constants;

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        if ($value instanceof static) {
            $value = $value->getValue();
        }

        $this->setValue($value);
    }

    /**
     * @return string|int|null
     */
    public function getKey()
    {
        return static::getKeyByValue($this->value);
    }

    /**
     * Return the current value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    private function setValue($value): void
    {
        if (!static::hasValue($value)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The value \'%s\' for enum class \'%s\' could not be mapped to a valid constant value',
                    $value,
                    static::class
                )
            );
        }

        $this->value = $value;
    }

    /**
     * Check if a constant key exists
     *
     * @param mixed $name
     *
     * @return bool
     */
    public static function hasKey($name): bool
    {
        return array_key_exists($name, static::toArray());
    }

    /**
     * Check if a constant value exists
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function hasValue($value): bool
    {
        return in_array($value, static::toArray(), true);
    }

    /**
     * Return an numerically indexed array of the constants names
     *
     * @return array<int, string>
     */
    public static function getKeys(): array
    {
        return array_keys(static::toArray());
    }

    /**
     * Return an numerically indexed array of the constants values
     *
     * @return array<int, string>
     */
    public static function getValues(): array
    {
        return array_values(static::toArray());
    }

    /**
     * Return a constant key matching the provided $value
     *
     * @param mixed $value
     *
     * @return string|null
     */
    public static function getKeyByValue($value): ?string
    {
        return array_flip(static::toArray())[$value] ?? null;
    }

    /**
     * Return a constant value matching $key
     *
     * @param string $key
     *
     * @return string|null
     */
    public static function getValueByKey(string $key): ?string
    {
        return static::toArray()[$key] ?? null;
    }

    /**
     * Return a key value map, with the array keys being the constant names with their associated constant values
     *
     * @return array<string, string>
     */
    public static function toArray(): array
    {
        if (!isset(static::$constants)) {
            static::$constants = (new \ReflectionClass(static::class))->getConstants();
        }

        return static::$constants;
    }
}
