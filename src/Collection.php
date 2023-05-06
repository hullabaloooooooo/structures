<?php

namespace Phox\Structures;

use Countable;
use Phox\Structures\Interfaces\ICollectable;
use Phox\Structures\Interfaces\ICollection;
use Phox\Structures\Interfaces\IDeletable;
use Phox\Structures\Interfaces\IGenerative;
use Phox\Structures\Interfaces\ISearchable;
use Phox\Structures\Interfaces\IType;
use Phox\Structures\Interfaces\ITypedStructure;

/**
 * @template T
 * @extends EnumerableArray<T>
 * @implements ICollection<T>
 * @implements IDeletable<T>
 * @implements ICollectable<T>
 * @implements ISearchable<T>
 * @implements IGenerative<T>
 */
class Collection extends EnumerableArray
    implements ICollection, IDeletable, ICollectable, Countable, ISearchable, IGenerative
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

    public function merge(array $items, bool $checkType = true): void
    {
        if ($checkType) {
            foreach ($items as $item) {
                $this->checkType($item);
            }
        }

        $this->items = array_merge($this->items, $items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function map(callable $mapper, ?IType $newType = null, bool $keepKeys = false): static
    {
        $newCollection = new static($newType ?? $this->type);

        foreach ($this->items as $key => $item) {
            $keepKeys
                ? $newCollection->set($key, $mapper($item))
                : $newCollection->add($mapper($item));
        }

        return $newCollection;
    }

    public function filter(callable $filter, bool $keepKeys = false): static
    {
        $newCollection = new static($this->type);

        foreach ($this->items as $key => $item) {
            if ($filter($item)) {
                $keepKeys
                    ? $newCollection->set($key, $item)
                    : $newCollection->add($item);
            }
        }

        return $newCollection;
    }

    public function each(callable $callback): void
    {
        foreach ($this->items as &$item) {
            $callback($item);
        }
    }

    public function where(
        Operator $operator,
        mixed $value,
        int|string|DepthKey|null $key = null,
        bool $keepKeys = false,
    ): static
    {
        $newCollection = new static($this->type);

        foreach ($this->items as $item) {
            $itemValue = $this->getValueFromItemByKey($item, $key);

            if (
                match ($operator) {
                    Operator::Equal => $itemValue == $value,
                    Operator::GreaterThan => $itemValue > $value,
                    Operator::GreaterThanOrEqual => $itemValue >= $value,
                    Operator::LessThan => $itemValue < $value,
                    Operator::LessThanOrEqual => $itemValue <= $value,
                    Operator::In => in_array($itemValue, $value),
                }
            ) {
                $keepKeys
                    ? $newCollection->set($key, $item)
                    : $newCollection->add($item);
            }
        }

        return $newCollection;
    }

    public function select(int|string|DepthKey $key, ?IType $type = null, bool $keepKeys = false): static
    {
        return $this->map(fn(mixed $item): mixed => $this->getValueFromItemByKey($item, $key), $type, $keepKeys);
    }

    public function replaceItems(ITypedStructure|array $data, bool $keepOriginal): void
    {
        if (!$keepOriginal) {
            $this->items = [];
        }

        $this->items = array_replace($this->items, is_array($data) ? $data : $data->toArray());
    }

    public function join(ITypedStructure|array $data): void
    {
        $this->items += is_array($data) ? $data : $data->toArray();
    }

    protected function getValueFromItemByKey(mixed $item, int|string|DepthKey|null $key): mixed
    {
        if (is_null($key)) {
            return $item;
        }

        if ($key instanceof DepthKey) {
            return $this->getValueByDepthKey($item, $key);
        }

        if (is_array($item)) {
            return $item[$key];
        }

        if (is_object($item)) {
            return $item->$key;
        }

        return null;
    }

    protected function getValueByDepthKey(mixed $item, DepthKey $key): mixed
    {
        if (!(is_array($item) || is_object($item))) {
            return null;
        }

        $path = $key->getPath();
        $value = $item;

        foreach ($path as $subKey) {
            $value = is_array($value)
                ? $value[$subKey]
                : $value->$subKey;
        }

        return $value;
    }
}
