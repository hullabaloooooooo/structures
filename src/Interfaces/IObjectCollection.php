<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 * @extends ICollection<T>
 */
interface IObjectCollection extends ICollection
{
    /**
     * @param class-string<T> $class
     * @return bool
     */
    public function hasObjectClass(string $class): bool;
}