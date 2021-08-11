<?php

namespace Phox\Structures\Abstracts\Traits;

use Phox\Structures\Exceptions\ArrayException;

/**
 * @template T
 */
trait TArray
{
    protected array $items = [];

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

    public function add(mixed $value): void
    {
        array_push($this->items, $value);
    }

    /**
     * @inheritdoc
     */
    public function get(int|string $key): mixed
    {
        return $this->items[$key] ?? throw new ArrayException();
    }

    public function set(int|string|null $key, mixed $value): void
    {
        if (is_null($key)) {
            $this->add($value);

            return;
        }

        if ($this->has($key)) {
            throw new ArrayException();
        }

        $this->replace($key, $value);
    }

    public function replace(int|string $key, mixed $value): mixed
    {
        $oldValue = $this->items[$key] ?? null;

        $this->items[$key] = $value;

        return $oldValue;
    }

    public function remove(int|string $key): mixed
    {
        $oldValue = $this->get($key) ?? null;

        if (is_null($oldValue)) {
            return null;
        }

        unset($this->items[$key]);

        return $oldValue;
    }

    public function has(int|string $key): bool
    {
        return array_key_exists($key, $this->items);
    }
}