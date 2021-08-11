<?php

namespace Phox\Structures\Interfaces;

interface ITypedStructure 
{
    public function allows(mixed $value): bool;

    public function getType(): string;
}