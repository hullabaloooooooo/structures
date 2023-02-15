<?php

namespace Phox\Structures;

use Phox\Structures\Abstracts\ObjectType;
use Phox\Structures\Interfaces\IObjectCollection;

/**
 * @template T of object
 * @extends Collection<T>
 * @implements IObjectCollection<T>
 */
class ObjectCollection extends Collection implements IObjectCollection
{
    /**
     * @param ObjectType<T> $type
     */
    public function __construct(ObjectType $type)
    {
        parent::__construct($type);
    }

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