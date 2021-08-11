<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 * @extends IArray<T>|IEnumerable<T>|ICountable<T>|IDeletable<T>
 */
interface ICollection extends IArray, IEnumerable, ICountable, IDeletable, IDeletableByKey, ICollectable
{
    /**
     * @param T|null $value
     * @return bool
     */
    public function allows(mixed $value): bool;

    /**
     * @return string|class-string<T>
     */
    public function getType(): string;

    /**
     * @return T|null
     */
    public function first(): mixed;

    /**
     * @param T $item
     * @return bool
     */
    public function contains(mixed $item): bool;

    /**
     * @param T $item
     * @return int|string|false
     */
    public function search(mixed $item): int|string|false;

    public function isEmpty(): bool;

    public function getKeys(): array;
}