<?php

namespace Phox\Structures;

use Phox\Structures\Exceptions\CollectionKeyTypeException;

/**
 * @template T
 * @extends Collection<T>
 */
class ListedCollection extends Collection
{
    public function get(int|string $key): mixed
    {
        $this->checkKey($key);

        return parent::get($key);
    }

    public function replace(int|string $key, mixed $value): mixed
    {
        $this->checkKey($key);

        return parent::replace($key, $value);
    }

    public function tryGet(int|string $key, mixed $default = null): mixed
    {
        $this->checkKey($key);

        return parent::tryGet($key, $default);
    }

    protected function checkKey(int|string $key)
    {
        if (!is_integer($key)) {
            throw new CollectionKeyTypeException();
        }
    }
}