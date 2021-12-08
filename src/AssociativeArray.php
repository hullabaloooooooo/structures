<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IAssociativeArray;
use Phox\Structures\Traits\TAssociativeArray;

/**
 * @template T
 * @extends ArrayObject<T>
 * @implements IAssociativeArray<T>
 */
class AssociativeArray extends ArrayObject implements IAssociativeArray
{
    use TAssociativeArray;
}