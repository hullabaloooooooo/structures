<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IAssociativeArray;
use Phox\Structures\Traits\TAssociativeArray;

/**
 * @template T
 * @extends Collection<T>
 * @implements IAssociativeArray<T>
 */
class AssociativeCollection extends Collection implements IAssociativeArray
{
    use TAssociativeArray;
}