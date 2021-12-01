<?php

namespace Phox\Structures;

use Countable;
use Phox\Structures\Interfaces\ICollectable;
use Phox\Structures\Interfaces\ICollection;
use Phox\Structures\Interfaces\IDeletable;
use Phox\Structures\Interfaces\ISearchable;

/**
 * @template T
 * @extends EnumerableArray<T>
 * @implements ICollection<T>
 * @implements IDeletable<T>
 * @implements ICollectable<T>
 * @implements ISearchable<T>
 */
class Collection extends EnumerableArray implements ICollection, IDeletable, ICollectable, Countable, ISearchable
{
    public function first(): mixed
    {
        $key = array_key_first($this->items);

        return is_null($key) ? null : $this->tryGet($key);
    }

    public function contains(mixed $item): bool
    {
        return in_array($item, $this->items);
    }

    public function getKeys(): array
    {
        return array_keys($this->items);
    }

    public function search(mixed $item): int|false
    {
        return array_search($item, $this->items);
    }

    public function searchAll(mixed $item): array
    {
        return array_keys($this->items, $item);
    }

    public function delete(mixed $item): void
    {
        $keys = $this->searchAll($item);

        $this->items = array_diff_key($this->items, array_flip($keys));
    }

    public function deleteFresh(mixed $value): void
    {
        $this->delete($value);

        $this->items = array_values($this->items);
    }

    public function collect(mixed ...$items): void
    {
        $this->clearItems();

        foreach ($items as $item) {
            is_array($item)
                ? $this->merge($item)
                : $this->add($item);
        }
    }

    public function merge(array $items): void
    {
        foreach ($items as $item) {
            $this->checkType($item);
        }

        $this->items = array_merge($this->items, $items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function tryGet(int $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }
}
