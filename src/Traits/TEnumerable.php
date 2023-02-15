<?php

namespace Phox\Structures\Traits;

/**
 * @template T
 */
trait TEnumerable 
{
    /** @var T[] */
    protected array $items = [];

    public function current(): mixed
    {
        return current($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function key(): int|null|string
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        return !is_null($this->key());
    }
}