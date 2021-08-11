<?php

namespace Phox\Structures\Interfaces;

use Phox\Structures\Exceptions\ArrayException;

/**
 * @template T
 */
interface IArray
{
    /**
     * @param T $value
     */
    public function add(mixed $value): void;

    /**
     * Get element of array by index
     *
     * @param int|string $key
     * @return T
     * @throws ArrayException
     */
    public function get(int $key): mixed;

    /**
     * Set element to array by index
     *
     * @param int|string|null $key
     * @param T $value
     * @throws ArrayException
     */
    public function set(int $key, mixed $value): void;

    /**
     * @param int|string $key
     * @param mixed $value
     * @return void
     */
    public function replace(int $key, mixed $value): void;

    /**
     * @param int|string $key
     * @return void
     */
    public function remove(int $key): void;

    /**
     * @param int $key
     * @return bool
     */
    public function has(int $key): bool;
}