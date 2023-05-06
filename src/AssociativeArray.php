<?php

namespace Phox\Structures;

use Phox\Structures\Exceptions\ArrayException;
use Phox\Structures\Interfaces\IAssociativeArray;

/**
 * @template T
 * @extends ArrayObject<T>
 * @implements IAssociativeArray<T>
 */
class AssociativeArray extends ArrayObject implements IAssociativeArray
{
    public function get(int|string $key): mixed
    {
        return is_string($key) ? $this->items[$key] ?? throw new ArrayException() : parent::get($key);
    }

    public function tryGet(int|string $key, mixed $default = null): mixed
    {
        return is_string($key) ? $this->items[$key] ?? $default : parent::tryGet($key, $default);
    }

    public function set(int|string|null $key, mixed $value): void
    {
        if (is_string($key)) {
            $this->has($key) ? throw new ArrayException() : $this->replace($key, $value);
        } else {
            parent::set($key, $value);
        }
    }

    public function has(int|string $key): bool
    {
        return is_string($key)
            ? array_key_exists($key, $this->items)
            : parent::has($key);
    }

    public function replace(int|string $key, mixed $value): void
    {
        if (is_string($key)) {
            $this->checkType($value);

            $this->items[$key] = $value;
        } else {
            parent::replace($key, $value);
        }
    }

    public function remove(int|string $key): void
    {
        if (is_string($key)) {
            unset($this->items[$key]);
        } else {
            parent::remove($key);
        }
    }
}