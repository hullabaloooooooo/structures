<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IAssociativeArray;

class AssociativeArray extends ArrayObject implements IAssociativeArray
{
    public function get(int|string $key): mixed
    {
        return $this->fullKeysGet($key);
    }

    public function set(int|string|null $key, mixed $value): void
    {
        $this->fullKeysSet($key, $value);
    }

    public function replace(int|string $key, mixed $value): void
    {
        $this->fullKeysReplace($key, $value);
    }

    public function remove(int|string $key): void
    {
        $this->fullKeysRemove($key);
    }

    public function has(int|string $key): bool
    {
        return $this->fullKeysHas($key);
    }
}