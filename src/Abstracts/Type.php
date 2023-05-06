<?php

namespace Phox\Structures\Abstracts;

use Phox\Structures\Interfaces\IType;

/**
 * @implements IType<mixed>
 */
enum Type: string implements IType
{
    case Integer = 'integer';
    case Double = 'double';
    case String = 'string';
    case Array = 'array';
    case Object = 'object';
    case Resource = 'resource';
    case Callable = 'callable';
    case Boolean = 'boolean';
    case Null = 'NULL';

    public static function fromValue(mixed $value): Type
    {
        return is_callable($value) 
            ? Type::Callable
            : Type::from(gettype($value));
    }

    public function getType(): string
    {
        return $this->value;
    }

    public function isSame(mixed $value): bool
    {
        if ($this == Type::Callable) {
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