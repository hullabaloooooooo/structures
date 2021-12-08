<?php

namespace Phox\Structures\Abstracts;

use Phox\Structures\Interfaces\IType;

/**
 * @template T
 * @inherits IType<T>
 */
enum Type: string implements IType
{
    case INTEGER = 'integer';
    case DOUBLE = 'double';
    case STRING = 'string';
    case ARRAY = 'array';
    case OBJECT = 'object';
    case RESOURCE = 'resource';
    case CALLABLE = 'callable';

    public static function fromValue(mixed $value): static
    {
        return is_callable($value) 
            ? static::CALLABLE
            : static::from(gettype($value));
    }

    public function getType(): string
    {
        return $this->value;
    }

    public function isSame(mixed $value): bool
    {
        if ($this == static::CALLABLE) {
            return is_callable($value);
        }

        return $this->value == gettype($value);
    }

    /**
     * @param IType<mixed>|string $type
     * @return boolean
     */
    public function isSameType(IType|string $type): bool
    {
        if ($type instanceof IType) {
            $type = $type->getType();
        }

        return $type == $this->value;
    }

    public function allows(mixed $value): bool
    {
        return $this->isSame($value);
    }

    /**
     * @param IType<mixed>|string $type
     * @return boolean
     */
    public function allowsType(IType|string $type): bool
    {
        return $this->isSameType($type);
    }
}