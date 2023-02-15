<?php

namespace Phox\Structures;

use Phox\Structures\Abstracts\Type;
use Phox\Structures\Interfaces\IType;
use Phox\Structures\Abstracts\Arrayable;
use Phox\Structures\Interfaces\IContainer;
use Phox\Structures\Exceptions\ArrayException;
use Phox\Structures\Interfaces\ITypedStructure;
use Phox\Structures\Exceptions\StructureTypeException;

/**
 * @template T
 * @extends Arrayable<T>
 * @implements IContainer<T>
 * @implements ITypedStructure<T>
 */
class ArrayObject extends Arrayable implements IContainer, ITypedStructure
{
    /**
     * @var array<T>
     */
    protected array $items = [];

    /**
     * @param IType<T> $type
     */
    public function __construct(protected readonly IType $type)
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

        $this->items[] = $value;
    }

    public function get(int $key): mixed
    {
        return $this->items[$key] ?? throw new ArrayException();
    }

    public function set(?int $key, mixed $value): void
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

    public function replace(int $key, mixed $value): void
    {
        $this->checkType($value);

        $this->items[$key] = $value;
    }

    public function remove(int $key): void
    {
        unset($this->items[$key]);
    }

    public function has(int $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    public function allows(mixed $value): bool
    {
        return $this->type->allows($value);
    }

    public function getType(): IType
    {
        return $this->type;
    }

    protected function checkType(mixed $value): void
    {
        if (!$this->allows($value)) {
            throw new StructureTypeException();
        }
    }
}