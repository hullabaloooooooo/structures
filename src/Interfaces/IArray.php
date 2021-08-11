<?php

namespace Phox\Structures\Interfaces;

use ArrayAccess;
use Phox\Structures\Exceptions\ArrayException;

/**
 * @template T
 */
interface IArray extends ArrayAccess
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
    public function get(int|string $key): mixed;

    /**
     * Set element to array by index
     *
     * @param int|string|null $key
     * @param T $value
     * @throws ArrayException
     */
    public function set(int|string|null $key, mixed $value): void;

    /**
     * @param int|string $key
     * @param mixed $value
     * @return T|null
     */
    public function replace(int|string $key, mixed $value): mixed;

    /**
     * @param int|string $key
     * @return T|null
     */
    public function remove(int|string $key): mixed;

    /**
     * @param int $key
     * @return bool
     */
    public function has(int|string $key): bool;
}