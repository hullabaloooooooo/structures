<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IEnumerable;

class EnumerableMap extends Map implements IEnumerable
{
    public function next()
    {
        next($this->keys);
    }

    public function key()
    {
        $key = key($this->keys);

        return $this->keys[$key];
    }

    public function valid(): bool
    {
        return !is_null($this->key());
    }

    public function rewind()
    {
        reset($this->keys);
    }

    public function current(): mixed
    {
        $currentKey = current($this->keys);

        return $this->get($currentKey);
    }
}