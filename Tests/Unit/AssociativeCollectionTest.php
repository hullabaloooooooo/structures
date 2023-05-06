<?php


use PHPUnit\Framework\TestCase;
use Phox\Structures\Abstracts\Type;
use Phox\Structures\AssociativeCollection;

class AssociativeCollectionTest extends TestCase
{
    public function testCollectionMethodsWithStringKey(): void
    {
        $collection = new AssociativeCollection(Type::Integer);

        $collection->set('key', 1);

        $this->assertEquals(1, $collection->get('key'));
        $this->assertTrue($collection->has('key'));

        $collection->replace('key', 2);
        $this->assertEquals(2, $collection->get('key'));

        $collection->remove('key');
        $this->assertTrue($collection->isEmpty());
    }
}
