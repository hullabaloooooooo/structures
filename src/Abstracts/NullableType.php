<?php

namespace Phox\Structures\Abstracts;

use Phox\Structures\Interfaces\IType;

/**
 * @template T
 * @implements IType<T>
 */
readonly class NullableType implements IType
{
    /**
     * @param IType<T> $type
     */
    public function __construct(protected IType $type)
    {

    }

    /**
     * @param IType<T> $type
     * @return self<T>
     */
    public static function from(IType $type): self
    {
        return new self($type);
    }

    public function getType(): string
    {
        return $this->type->getType();
    }

    public function isSame(mixed $value): bool
    {
        return is_null($value) || $this->type->isSame($value);
    }

    public function isSameType(string|IType $type): bool
    {
        return $type == Type::Null || $this->type->isSameType($type);
    }

    public function allows(mixed $value): bool
    {
        return is_null($value) || $this->type->allows($value);
    }

    public function allowsType(string|IType $type): bool
    {
        return $type == Type::Null || $this->type->allowsType($type);
    }
}