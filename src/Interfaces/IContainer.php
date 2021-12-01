<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface IContainer 
{
    /**
     * Get all items from container
     *
     * @return array<T>
     */
    public function getItems(): array;

    /**
     * Delete all items from container
     *
     * @return void
     */
    public function clearItems(): void;

    /**
     * Check if container is empty
     *
     * @return boolean
     */
    public function isEmpty(): bool;
}