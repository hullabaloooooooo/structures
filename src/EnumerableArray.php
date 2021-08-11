<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IEnumerableArray;
use Phox\Structures\Traits\TEnumerable;

class EnumerableArray extends ArrayObject implements IEnumerableArray
{
    use TEnumerable;
}