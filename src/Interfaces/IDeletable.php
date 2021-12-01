<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface IDeletable
{
    /**
     * Method keeps keys
     * 
     * @param T $item
     */
    public function delete(mixed $item): void;

    /**
     * Delete values and reset keys
     *
     * @param T $value
     */
    public function deleteFresh(mixed $value): void;
}