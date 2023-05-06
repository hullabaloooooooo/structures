<?php

namespace Phox\Structures\Abstracts;

use LogicException;
use Phox\Structures\Interfaces\IType;

readonly class UnionType implements IType
{
    /**
     * @param array<IType> $types
     */
    public function __construct(protected array $types)
    {
        foreach ($this->types as $type) {
            if (!($type instanceof IType)) {
                throw new LogicException();
            }
        }
    }

    public static function from(array $types): self
    {
        return new self($types);
    }

    public function getType(): string
    {
        return implode('|', array_map(fn(IType $type): string => $type->getType(), $this->types));
    }

    public function isSame(mixed $value): bool
    {
        foreach ($this->types as $type) {
            if ($type->isSame($value)) {
                return true;
            }
        }

        return false;
    }

    public function isSameType(string|IType $type): bool
    {
        foreach ($this->types as $typeItem) {
            if ($typeItem->isSameType($type)) {
                return true;
            }
        }

        return false;
    }

    public function allows(mixed $value): bool
    {
        foreach ($this->types as $type) {
            if ($type->allows($value)) {
                return true;
            }
        }

        return false;
    }

    public function allowsType(string|IType $type): bool
    {
        foreach ($this->types as $typeItem) {
            if ($typeItem->allowsType($type)) {
                return true;
            }
        }

        return false;
    }
}