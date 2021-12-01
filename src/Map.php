<?php

namespace Phox\Structures;

use LogicException;
use Phox\Structures\Abstracts\Arrayable;
use Phox\Structures\Exceptions\ArrayException;
use Phox\Structures\Exceptions\StructureTypeException;
use Phox\Structures\Interfaces\IMap;

/**
 * @template T
 * @template K
 * @implements IMap<T, K>
 */
class Map extends Arrayable implements IMap
{
    protected array $keys = [];
    protected array $values = [];

    /**
     * @param string|class-string<K> $keyType
     * @param string|class-string<T> $valueType
     */
    public function __construct(protected string $keyType, protected string $valueType)
    {

    }

    /**
     * @inheritDoc
     */
    public function set(mixed $key, mixed $value): void
    {
        $this->checkTypes($key, $value);

        if ($this->has($key)) {
            throw new ArrayException();
        }

        array_push($this->keys, $key);
        array_push($this->values, $value);
    }

    /**
     * @inheritDoc
     */
    public function get(mixed $key): mixed
    {
        $index = array_search($key, $this->keys);

        return $this->values[$index] ?? throw new ArrayException();
    }

    /**
     * @inheritDoc
     */
    public function replace(mixed $key, mixed $value): void
    {
        $this->checkTypes($key, $value);

        $index = array_search($key, $this->keys);

        if ($index === false) {
            array_push($this->keys, $key);
            array_push($this->values, $value);
        } else {
            $this->values[$index] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $key): void
    {
        $index = array_search($key, $this->keys);

        if ($index !== false) {
            unset($this->keys[$index]);
            unset($this->values[$index]);
        }
    }

    public function has(mixed $key): bool
    {
        $index = array_search($key, $this->keys);

        return $index !== false;
    }

    public function allowsKey(mixed $key): bool
    {
        return $this->allowsType($this->keyType, $key);
    }

    public function allows(mixed $value): bool
    {
        return $this->allowsType($this->valueType, $value);
    }

    protected function allowsType(string $expected, mixed $value): bool
    {
        $actualType = is_object($value) ? get_class($value) : gettype($value);

        if ($expected == 'callable') {
            return is_callable($value);
        }

        if (is_object($value)) {
            return $value instanceof $expected || $expected == 'object';
        }

        return $actualType == $expected;
    }

    protected function checkTypes(mixed $key, mixed $value): void
    {
        if (!$this->allowsKey($key) || !$this->allows($value)) {
            throw new StructureTypeException();
        }
    }

    public function add(mixed $value): void
    {
        throw new LogicException();
    }
}