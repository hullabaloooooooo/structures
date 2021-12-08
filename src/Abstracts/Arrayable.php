<?php

namespace Phox\Structures\Abstracts;

use ArrayAccess;
use Phox\Structures\Interfaces\IArray;

/**
 * @template T
 * @implements IArray<T>
 * @implements ArrayAccess<int, T>
 */
abstract class Arrayable implements ArrayAccess, IArray
{
    /**
     * @param int $offset
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @param int $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @param int $offset
     * @param T $value
     * @return void
     */
    public function offsetSet($offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @param int $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }
}