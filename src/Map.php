<?php

namespace Phox\Structures;

use LogicException;
use Phox\Structures\Abstracts\Arrayable;
use Phox\Structures\Exceptions\ArrayException;
use Phox\Structures\Exceptions\StructureTypeException;
use Phox\Structures\Interfaces\IMap;
use Phox\Structures\Interfaces\IType;

/**
 * @template T
 * @template K
 * @extends Arrayable<T>
 * @implements IMap<T, K>
 */
class Map extends Arrayable implements IMap
{
    /**
     * @var array<K>
     */
    protected array $keys = [];

    /**
     * @var array<T>
     */
    protected array $values = [];

    /**
     * @param IType<K> $keyType
     * @param IType<T> $valueType
     */
    public function __construct(protected IType $keyType, protected IType $valueType)
    {

    }

    /**
     * @param K $key
     * @param T $value
     * @return void
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
     * @param K $key
     * @return T
     */
    public function get(mixed $key): mixed
    {
        $index = array_search($key, $this->keys);

        return $this->values[$index] ?? throw new ArrayException();
    }

    /**
     * @param K $key
     * @param T $value
     * @return void
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
     * @param K $key
     * @return void
     */
    public function remove(mixed $key): void
    {
        $index = array_search($key, $this->keys);

        if ($index !== false) {
            unset($this->keys[$index]);
            unset($this->values[$index]);
        }
    }

    /**
     * @param K $key
     * @return boolean
     */
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

    /**
     * @param IType<mixed> $expected
     * @param mixed $value
     * @return boolean
     */
    protected function allowsType(IType $expected, mixed $value): bool
    {
        return $expected->allows($value);
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