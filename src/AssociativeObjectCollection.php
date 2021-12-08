<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IAssociativeArray;
use Phox\Structures\Traits\TAssociativeArray;

/**
 * @template T
 * @extends ObjectCollection<T>
 * @implements IAssociativeArray<T>
 */
class AssociativeObjectCollection extends ObjectCollection implements IAssociativeArray
{
    use TAssociativeArray;
}