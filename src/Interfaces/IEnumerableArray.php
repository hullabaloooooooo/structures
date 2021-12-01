<?php

namespace Phox\Structures\Interfaces;

/**
 * @template T
 *
 * @extends IArray<T>
 * @extends IEnumerable<T>
 */
interface IEnumerableArray extends IArray, IEnumerable 
{
    
}