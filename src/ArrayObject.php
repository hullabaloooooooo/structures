<?php

namespace Phox\Structures;

use Phox\Structures\Abstracts\Arrayable;
use Phox\Structures\Interfaces\IContainer;
use Phox\Structures\Exceptions\ArrayException;
use Phox\Structures\Exceptions\StructureTypeException;
use Phox\Structures\Interfaces\ITypedStructure;

/**
 * @template T
 * @extends Arrayable<T>
 * @implements IContainer<T>
 * @implements ITypedStructure<T>
 */
class ArrayObject extends Arrayable implements IContainer, ITypedStructure
{
    protected array $items = [];

    /**
     * @param class-string<T>|string $type
     */
    public function __construct(protected string $type)
    {
        //
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function clearItems(): void
    {
        $this->items = [];
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function add(mixed $value): void
    {
        $this->checkType($value);

        array_push($this->items, $value);
    }

    public function get(int $key): mixed
    {
        return $this->fullKeysGet($key);
    }

    public function set(?int $key, mixed $value): void
    {
        $this->fullKeysSet($key, $value);
    }

    public function replace(int $key, mixed $value): void
    {
        $this->fullKeysReplace($key, $value);
    }

    public function remove(int $key): void
    {
        $this->fullKeysRemove($key);
    }

    public function has(int $key): bool
    {
        return $this->fullKeysHas($key);
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

    public function getType(): string
    {
        return $this->type;
    }

    protected function checkType(mixed $value)
    {
        if (!$this->allows($value)) {
            throw new StructureTypeException();
        }
    }

    protected function fullKeysGet(int|string $key): mixed
    {
        return $this->items[$key] ?? throw new ArrayException();
    }

    protected function fullKeysSet(int|string|null $key, mixed $value): void
    {
        if (is_null($key)) {
            $this->add($value);

            return;
        }

        if ($this->fullKeysHas($key)) {
            throw new ArrayException();
        }

        $this->fullKeysReplace($key, $value);
    }

    protected function fullKeysReplace(int|string $key, mixed $value): void
    {
        $this->checkType($value);

        $this->items[$key] = $value;
    }

    protected function fullKeysRemove(int|string $key): void
    {
        unset($this->items[$key]);
    }

    protected function fullKeysHas(int|string $key): bool
    {
        return array_key_exists($key, $this->items);
    }
}