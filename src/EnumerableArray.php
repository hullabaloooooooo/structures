<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IEnumerableArray;
use Phox\Structures\Traits\TEnumerable;

/**
 * @template T
 * @extends ArrayObject<T>
 * @implements IEnumerableArray<T>
 */
class EnumerableArray extends ArrayObject implements IEnumerableArray
{
    /** @phpstan-use TEnumerable<T> */
    use TEnumerable;
}