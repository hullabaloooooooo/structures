<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface IDeletable
{
    /**
     * @param T $item
     */
    public function delete(mixed $item): void;
}