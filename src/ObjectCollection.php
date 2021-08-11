<?php

namespace Phox\Structures;

use Phox\Structures\Exceptions\StructureTypeException;
use Phox\Structures\Interfaces\IObjectCollection;

/**
 * @template T
 * @extends Collection<T>
 */
class ObjectCollection extends Collection implements IObjectCollection
{
    /**
     * @param class-string<T> $type
     */
    public function __construct(string $type)
    {
        if (!class_exists($type)) {
            throw new StructureTypeException();
        }

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