<?php


use Phox\Structures\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class AssociativeCollectionTest extends TestCase
{
    public function testCollectionMethodsWithStringKey(): void
    {
        $collection = new AssociativeCollection('integer');

        $collection->set('key', 1);

        $this->assertEquals(1, $collection->get('key'));
        $this->assertTrue($collection->has('key'));

        $collection->replace('key', 2);
        $this->assertEquals(2, $collection->get('key'));

        $collection->remove('key');
        $this->assertTrue($collection->isEmpty());
    }
}
