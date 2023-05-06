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
     * @param int $key
     * @return T
     * @throws ArrayException
     */
    public function get(int $key): mixed;

    /**
     * @param int $key
     * @param T|null $default
     * @return T
     */
    public function tryGet(int $key, mixed $default = null): mixed;

    /**
     * Set element to array by index
     *
     * @param int $key
     * @param T $value
     * @throws ArrayException
     */
    public function set(int $key, mixed $value): void;

    /**
     * @param int $key
     * @param T $value
     * @return void
     */
    public function replace(int $key, mixed $value): void;

    /**
     * @param int $key
     * @return void
     */
    public function remove(int $key): void;

    /**
     * @param int $key
     * @return bool
     */
    public function has(int $key): bool;
}