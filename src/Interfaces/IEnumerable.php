<?php

namespace Phox\Structures\Interfaces;

use Iterator;

/**
 * Interpretation of Linked List data structure
 *
 * @template T
 */
interface IEnumerable extends Iterator
{
    /**
     * @return T|false
     */
    public function current(): mixed;
}