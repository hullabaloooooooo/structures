<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface IType
{
    /**
     * @return string|class-string<T>
     */
    public function getType(): string;

    /**
     * @param mixed $value
     * @return boolean
     */
    public function isSame(mixed $value): bool;

    /**
     * @param IType<mixed>|string $type
     * @return boolean
     */
    public function isSameType(IType|string $type): bool;

    /**
     * @param mixed $value
     * @return boolean
     */
    public function allows(mixed $value): bool;

    /**
     * @param IType<mixed>|string $type
     * @return boolean
     */
    public function allowsType(IType|string $type): bool;
}