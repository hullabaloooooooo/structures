<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface ICollectable
{
    /**
     * @param T|array<T> ...$items
     */
    public function collect(mixed ...$items): void;

    /**
     * @param array<T> $items
     */
    public function merge(array $items): void;
}