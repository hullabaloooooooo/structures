<?php

namespace Phox\Structures\Abstracts;

use Phox\Structures\Interfaces\IEnumerable;
use Phox\Structures\Traits\TEnumerable;

/**
 * @template T
 * @implements IEnumerable<T>
 */
abstract class Enumerable implements IEnumerable
{
    /** @phpstan-use TEnumerable<T> */
    use TEnumerable;
}