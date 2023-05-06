<?php

namespace Phox\Structures\Interfaces;

use Phox\Structures\Exceptions\ArrayException;

/**
 * @template T
 */
interface IAssociativeArray extends IArray
{
    /**
     * @param int|string $key
     * @return T
     * @throws ArrayException
     */
    public function get(int|string $key): mixed;

    /**
     * @param int|string $key
     * @param T|null $default
     * @return T
     */
    public function tryGet(int|string $key, mixed $default = null): mixed;

    /**
     * Set element to array by index
     *
     * @param int|string $key
     * @param T $value
     * @throws ArrayException
     */
    public function set(int|string $key, mixed $value): void;

    /**
     * @param int|string $key
     * @param T $value
     * @return void
     */
    public function replace(int|string $key, mixed $value): void;

    /**
     * @param int|string $key
     * @return void
     */
    public function remove(int|string $key): void;

    /**
     * @param int|string $key
     * @return bool
     */
    public function has(int|string $key): bool;
}