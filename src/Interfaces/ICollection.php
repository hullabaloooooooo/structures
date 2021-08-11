<?php

namespace Phox\Structures\Interfaces;

use Countable;

/**
 * @template T
 * @extends IArray<T>|IEnumerable<T>|ICountable<T>|IDeletable<T>
 */
interface ICollection
{
    /**
     * @return T|null
     */
    public function first(): mixed;

    /**
     * @param T $item
     * @return bool
     */
    public function contains(mixed $item): bool;

    /**
     * Get all keys
     *
     * @return array
     */
    public function getKeys(): array;

    /**
     * Delete items by value and reset keys
     *
     * @param mixed $value
     * @return void
     */
    public function deleteFresh(mixed $value): void;
}