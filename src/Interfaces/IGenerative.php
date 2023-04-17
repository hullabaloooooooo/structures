<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface IGenerative
{
    /**
     * @template K
     * @param callable(T): K $mapper
     * @param IType<K>|null $newType
     * @param bool $keepKeys
     * @return static<K>
     */
    public function map(callable $mapper, ?IType $newType = null, bool $keepKeys = false): static;

    /**
     * @param callable(T): bool $filter
     * @param bool $keepKeys
     * @return static<T>
     */
    public function filter(callable $filter, bool $keepKeys = false): static;

    /**
     * @param callable(T): mixed $callback
     * @return void
     */
    public function each(callable $callback): void;
}