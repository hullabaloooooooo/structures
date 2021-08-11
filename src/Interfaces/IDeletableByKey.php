<?php

namespace Phox\Structures\Interfaces;

interface IDeletableByKey
{
    public function deleteByKey(int|string $key): void;
}