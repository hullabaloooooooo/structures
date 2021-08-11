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
}