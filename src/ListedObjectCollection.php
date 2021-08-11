<?php

namespace Phox\Structures;

use Phox\Structures\Abstracts\Traits\TObjectCollection;
use Phox\Structures\Exceptions\CollectionTypeException;
use Phox\Structures\Interfaces\IObjectCollection;

/**
 * @template T
 * @extends ListedCollection<T>
 */
class ListedObjectCollection extends ListedCollection implements IObjectCollection
{
    use TObjectCollection;

    /**
     * @param class-string<T> $type
     */
    public function __construct(string $type)
    {
        if (!class_exists($type)) {
            throw new CollectionTypeException();
        }

        parent::__construct($type);
    }
}