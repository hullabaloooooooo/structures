<?php

namespace Phox\Structures\Abstracts\Traits;

trait TObjectCollection
{
    protected array $items = [];

    public function hasObjectClass(string $class): bool
    {
        foreach ($this->items as $item) {
            if (get_class($item) == $class) {
                return true;
            }
        }

        return false;
    }
}