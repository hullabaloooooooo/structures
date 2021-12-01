<?php

namespace Phox\Structures\Traits;

trait TAssociativeArray
{
    protected abstract function fullKeysGet(int|string $key): mixed;

    protected abstract function fullKeysSet(int|string|null $key, mixed $value): void;

    protected abstract function fullKeysReplace(int|string $key, mixed $value): void;

    protected abstract function fullKeysRemove(int|string $key): void;

    protected abstract function fullKeysHas(int|string $key): bool;

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