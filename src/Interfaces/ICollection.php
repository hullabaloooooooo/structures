<?php

namespace Phox\Structures\Interfaces;

use Phox\Structures\DepthKey;
use Phox\Structures\Operator;

/**
 * @template T
 */
interface ICollection
{
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
     * Get all keys
     *
     * @return array<int>
     */
    public function getKeys(): array;

    /**
     * @param Operator $operator
     * @param mixed $value
     * @param int|string|DepthKey|null $key
     * @param bool $keepKeys
     * @return static<T>
     */
    public function where(
        Operator $operator,
        mixed $value,
        int|string|DepthKey|null $key = null,
        bool $keepKeys = false,
    ): static;

    /**
     * @template K
     * @param int|string|DepthKey $key
     * @param IType<K>|null $type
     * @param bool $keepKeys
     * @return static<T, K>
     */
    public function select(int|string|DepthKey $key, ?IType $type = null, bool $keepKeys = false): static;
}