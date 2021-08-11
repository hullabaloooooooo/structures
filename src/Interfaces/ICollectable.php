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

    public function merge(array $items): void;

    public function clear(): void;
}