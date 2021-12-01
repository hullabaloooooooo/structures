<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface ISearchable 
{
    /**
     * Get first key by value
     * 
     * @param T $item
     * @return int|false
     */
    public function search(mixed $item): int|false;

    /**
     * Get all keys by value
     *
     * @param T $item
     * @return array
     */
    public function searchAll(mixed $item): array;
}