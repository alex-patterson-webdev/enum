<?php

declare(strict_types=1);

namespace Arp\Enum;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\Enum
 */
interface EnumInterface
{
    /**
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    public function __construct($value);

    /**
     * @return string|null
     */
    public function getKey(): ?string;

    /**
     * Return the current value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Check if a constant key exists
     *
     * @param string $name
     *
     * @return bool
     */
    public static function hasKey(string $name): bool;

    /**
     * Check if a constant value exists
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function hasValue($value): bool;

    /**
     * Return an numerically indexed array of the constants names
     *
     * @return array<int, string>
     */
    public static function getKeys(): array;

    /**
     * Return an numerically indexed array of the constants values
     *
     * @return array<int, string>
     */
    public static function getValues(): array;

    /**
     * Return a constant key matching the provided $value
     *
     * @param mixed $value
     *
     * @return string|null
     */
    public static function getKeyByValue($value): ?string;

    /**
     * Return a constant value matching $key
     *
     * @param string $key
     *
     * @return string|null
     */
    public static function getValueByKey(string $key): ?string;

    /**
     * Return a key value map, with the array keys being the constant names with their associated constant values
     *
     * @return array<string, string>
     */
    public static function toArray(): array;
}
