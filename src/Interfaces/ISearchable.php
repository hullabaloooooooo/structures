<?php

namespace Phox\Structures\Interfaces;

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
     * @param mixed $item
     * @return array
     */
    public function searchAll(mixed $item): array;
}