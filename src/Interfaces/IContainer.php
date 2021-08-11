<?php

namespace Phox\Structures\Interfaces;

interface IContainer 
{
    /**
     * Get all items from container
     *
     * @return array
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