<?php

use Phox\Structures\Abstracts\Type;
use Phox\Structures\Interfaces\IType;
use Phox\Structures\Abstracts\ObjectType;

if (!function_exists('type')) {
    /**
     * @template T
     * @param class-string<T> $original
     * @return IType<T>
     */
    function type(string $original): IType
    {
        return class_exists($original)
            ? ObjectType::fromClass($original)
            : Type::from($original);
    }
}

if (!function_exists('typeOf')) {
    /**
     * @template T
     * @param T $value
     * @return IType<T>
     */
    function typeOf(mixed $value): IType
    {
        return is_object($value)
            ? ObjectType::fromObject($value)
            : Type::fromValue($value);
    }
}