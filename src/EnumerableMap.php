<?php

namespace Phox\Structures;

use Phox\Structures\Exceptions\ArrayException;
use Phox\Structures\Interfaces\IEnumerable;

/**
 * @template T
 * @template K
 * @extends Map<T, K>
 * @implements IEnumerable<T>
 */
class EnumerableMap extends Map implements IEnumerable
{
    public function next(): void
    {
        next($this->keys);
    }

    /**
     * @return K
     */
    public function key(): mixed
    {
        $key = key($this->keys);

        return $this->keys[$key];
    }

    public function valid(): bool
    {
        return !is_null($this->key());
    }

    public function rewind(): void
    {
        reset($this->keys);
    }

    public function current(): mixed
    {
        $currentKey = current($this->keys);

        return $currentKey === false 
            ? throw new ArrayException() 
            : $this->get($currentKey);
    }
}