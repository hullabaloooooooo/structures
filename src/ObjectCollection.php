<?php

namespace Phox\Structures;

use Phox\Structures\Abstracts\Traits\TObjectCollection;
use Phox\Structures\Exceptions\CollectionTypeException;
use Phox\Structures\Interfaces\IObjectCollection;

/**
 * @template T
 * @extends Collection<T>
 */
class ObjectCollection extends Collection implements IObjectCollection
{
    use TObjectCollection;

    /**
     * @var array<class-string<T>>
     */
    protected array $classes = [];

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