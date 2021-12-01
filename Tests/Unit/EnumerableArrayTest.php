<?php

namespace Tests\Unit;

use Phox\Structures\EnumerableArray;
use PHPUnit\Framework\TestCase;

class EnumerableArrayTest extends TestCase 
{
    public function testEnumerableCanForeach()
    {
        $enumerableArray = new EnumerableArray('integer');
        $items = [5, 7, 1];
        
        foreach ($items as $item) {
            $enumerableArray->add($item);
        }

        foreach ($enumerableArray as $key => $item) {
            $this->assertEquals($items[$key], $item);
        }
    }
}