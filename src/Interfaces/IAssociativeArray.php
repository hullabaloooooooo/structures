<?php

namespace Phox\Structures\Interfaces;

use Phox\Structures\Exceptions\ArrayException;

/**
 * @template T
 */
interface IAssociativeArray
{
    /**
     * @param T $value
     */
    public function add(mixed $value): void;

    /**
     * @param int|string $key
     * @return T
     * @throws ArrayException
     */
    public function get(int|string $key): mixed;

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