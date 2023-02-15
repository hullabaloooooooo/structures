<?php


use PHPUnit\Framework\TestCase;
use Phox\Structures\Abstracts\Type;
use Phox\Structures\AssociativeArray;

class AssociativeArrayTest extends TestCase
{
    public function testReplace(): void
    {
        $array = new AssociativeArray(Type::INTEGER);

        $array->set('test', 1);
        $array->replace('test', 5);

        $this->assertEquals(5, $array->get('test'));
    }

    public function testGetAndSet(): void
    {
        $array = new AssociativeArray(Type::INTEGER);

        $array->set('test', 1);

        $this->assertEquals(1, $array->get('test'));
    }

    public function testRemove(): void
    {
        $array = new AssociativeArray(Type::INTEGER);

        $array->set('test', 1);
        $array->remove('test');

        $this->assertTrue($array->isEmpty());
    }

    public function testHas(): void
    {
        $array = new AssociativeArray(Type::INTEGER);

        $array->set('test', 1);

        $this->assertTrue($array->has('test'));
    }
}
