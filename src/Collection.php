<?php

namespace Phox\Structures;

use Phox\Structures\Abstracts\Traits\TArray;
use Phox\Structures\Abstracts\Traits\TEnumerable;
use Phox\Structures\Exceptions\CollectionTypeException;
use Phox\Structures\Interfaces\ICollection;

/**
 * @template T
 * @implements ICollection<T>
 */
class Collection implements ICollection
{
    use TEnumerable;
    use TArray {
        add as traitAdd;
        set as traitSet;
        replace as traitReplace;
    }

    /**
     * @param class-string<T>|string $type
     */
    public function __construct(protected string $type)
    {

    }

    public function first(): mixed
    {
        $key = array_key_first($this->items);

        return $this->tryGet($key);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function contains(mixed $item): bool
    {
        return in_array($item, $this->items);
    }

    public function getKeys(): array
    {
        return array_keys($this->items);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function search(mixed $item): int|string|false
    {
        return array_search($item, $this->items);
    }

    public function delete(mixed $item): void
    {
        $key = array_search($item, $this->items);

        if ($key !== false) {
            unset($this->items[$key]);
        }
    }

    public function deleteByKey(int|string $key): void
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
        }
    }

    public function collect(mixed ...$items): void
    {
        $this->clear();

        foreach ($items as $item) {
            is_array($item)
                ? $this->merge($item)
                : $this->add($item);
        }
    }

    public function merge(array $items): void
    {
        foreach ($items as $item) {
            $this->check($item);
        }

        $this->items = array_merge($this->items, $items);
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function all(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function add(mixed $value): void
    {
        $this->check($value);

        $this->traitAdd($value);
    }

    public function set(int|string|null $key, mixed $value): void
    {
        $this->check($value);

        $this->traitSet($key, $value);
    }

    public function replace(int|string $key, mixed $value): mixed
    {
        $this->check($value);

        return $this->traitReplace($key, $value);
    }

    public function tryGet(int|string $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }

    public function allows(mixed $value): bool
    {
        $actualType = is_object($value) ? get_class($value) : gettype($value);

        if ($this->type == 'callable') {
            return is_callable($value);
        }

        if (is_object($value)) {
            return $value instanceof $this->type || $this->type == 'object';
        }

        return $actualType == $this->type;
    }

    protected function check(mixed $value): void
    {
        if (!$this->allows($value)) {
            throw new CollectionTypeException();
        }
    }
}