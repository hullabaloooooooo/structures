<?php

namespace Phox\Structures\Abstracts;

use Phox\Structures\Interfaces\IType;

readonly class IntersectionType extends UnionType
{
    public static function from(array $types): self
    {
        return new self($types);
    }

    public function getType(): string
    {
        return implode('&', array_map(fn(IType $type): string => $type->getType(), $this->types));
    }

    public function isSame(mixed $value): bool
    {
        foreach ($this->types as $type) {
            if (!$type->isSame($value)) {
                return false;
            }
        }

        return true;
    }

    public function isSameType(string|IType $type): bool
    {
        foreach ($this->types as $typeItem) {
            if (!$typeItem->isSameType($type)) {
                return false;
            }
        }

        return true;
    }

    public function allows(mixed $value): bool
    {
        foreach ($this->types as $type) {
            if (!$type->allows($value)) {
                return false;
            }
        }

        return true;
    }

    public function allowsType(string|IType $type): bool
    {
        foreach ($this->types as $typeItem) {
            if (!$typeItem->allowsType($type)) {
                return false;
            }
        }

        return true;
    }
}