<?php

namespace Phox\Structures\Abstracts;

use ArrayAccess;
use Phox\Structures\Interfaces\IArray;

abstract class Arrayable implements ArrayAccess, IArray
{
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }
}