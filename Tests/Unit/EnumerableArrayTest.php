<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phox\Structures\Abstracts\Type;
use Phox\Structures\EnumerableArray;

class EnumerableArrayTest extends TestCase 
{
    public function testEnumerableCanForeach(): void
    {
        $enumerableArray = new EnumerableArray(Type::Integer);
        $items = [5, 7, 1];
        
        foreach ($items as $item) {
            $enumerableArray->add($item);
        }

        foreach ($enumerableArray as $key => $item) {
            $this->assertEquals($items[$key], $item);
        }
    }
}