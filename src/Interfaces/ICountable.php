<?php

namespace Phox\Structures\Interfaces;

use Countable;

/**
 * @template T
 */
interface ICountable extends Countable
{
    /**
     * @return array<T>
     */
    public function all(): array;
}