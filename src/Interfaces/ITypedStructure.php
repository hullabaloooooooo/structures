<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface ITypedStructure 
{
    /**
     * @param IType<T> $type
     */
    public function __construct(IType $type);

    /**
     * @param T $value
     * @return bool
     */
    public function allows(mixed $value): bool;

    /**
     * @return IType<T>
     */
    public function getType(): IType;
}