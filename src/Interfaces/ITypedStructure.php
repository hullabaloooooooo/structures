<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 */
interface ITypedStructure 
{
    /**
     * @param T $value
     * @return bool
     */
    public function allows(mixed $value): bool;

    /**
     * @return string|class-string<T>
     */
    public function getType(): string;
}