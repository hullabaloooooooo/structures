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
    public function merge(array $items, bool $checkType = true): void;

    /**
     * @param array<T>|ITypedStructure<T> $data
     * @param bool $keepOriginal
     * @return void
     */
    public function replaceItems(array|ITypedStructure $data, bool $keepOriginal): void;

    /**
     * @param array<T>|ITypedStructure<T> $data
     * @return void
     */
    public function join(array|ITypedStructure $data): void;
}