<?php

use Phox\Structures\Abstracts\Type;
use Phox\Structures\Interfaces\IType;
use Phox\Structures\Abstracts\ObjectType;

if (!function_exists('type')) {
    /**
     * @param string|class-string $original
     * @return IType
     *
     * @throws ValueError
     */
    function type(string $original): IType
    {
        return class_exists($original)
            ? ObjectType::fromClass($original)
            : Type::from($original);
    }
}

if (!function_exists('typeOf')) {
    function typeOf(mixed $value): IType
    {
        return is_object($value)
            ? ObjectType::fromObject($value)
            : Type::fromValue($value);
    }
}