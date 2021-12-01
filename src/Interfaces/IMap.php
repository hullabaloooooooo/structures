<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 * @template K
 */
interface IMap
{
    /**
     * @param K $key
     * @param T $value
     */
    public function set(mixed $key, mixed $value): void;

    /**
     * @param K $key
     * @return T
     */
    public function get(mixed $key): mixed;

    /**
     * @param K $key
     * @param T $value
     */
    public function replace(mixed $key, mixed $value): void;

    /**
     * @param K $key
     */
    public function remove(mixed $key): void;

    /**
     * @param K $key
     * @return bool
     */
    public function has(mixed $key): bool;

    public function allowsKey(mixed $key): bool;

    public function allows(mixed $value): bool;
}