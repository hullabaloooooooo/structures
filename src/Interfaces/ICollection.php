<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
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
     * @return array<int>
     */
    public function getKeys(): array;
}