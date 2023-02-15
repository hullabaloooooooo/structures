<?php

namespace Tests\Unit;

use Phox\Structures\Abstracts\ObjectType;
use stdClass;
use Phox\Structures\Collection;
use PHPUnit\Framework\TestCase;
use Phox\Structures\Abstracts\Type;
use Phox\Structures\Exceptions\StructureTypeException;

class CollectionTest extends TestCase
{
    public function testAllows(): void
    {
        $collection = new Collection(ObjectType::fromClass(CollectionTest::class));

        $this->expectException(StructureTypeException::class);

        $collection->add(1);
    }

    public function testCollectionAllowSameType(): void
    {
        $collection = new Collection(ObjectType::fromClass(TestCase::class));
        $objectCollection = new Collection(Type::OBJECT);

        $this->assertTrue($collection->allows($this));
        $this->assertFalse($collection->allows(new stdClass()));

        $this->assertTrue($objectCollection->allows($this));
        $this->assertTrue($objectCollection->allows(new stdClass()));
    }

    public function testTryGetMethod(): void
    {
        $collection = new Collection(Type::STRING);

        $collection->set(5, 'value 5');

        $this->assertEquals('value 5', $collection->tryGet(5));
        $this->assertNull($collection->tryGet(1));
        $this->assertEquals('value 1', $collection->tryGet(1, 'value 1'));
    }

    public function testMergeMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $collection->add(2);
        $collection->add(5);
        $collection->merge([4, 3]);
        
        $this->assertEquals([2, 5, 4, 3], $collection->getItems());
        $this->expectException(StructureTypeException::class);

        $collection->merge([7, 'hello']);
    }

    public function testCollectMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $collection->collect(1, 2, 3);
        $this->assertEquals([1, 2, 3], $collection->getItems());

        $collection->collect([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $collection->getItems());

        $collection->collect([1, 2, 3], 4, [5, 6], 7, 8);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8], $collection->getItems());
    }

    public function testFirstMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $this->assertNull($collection->first());

        $collection->collect(5, 2, 3, 1);
        $this->assertEquals(5, $collection->first());

        $collection->delete(5);
        $this->assertEquals(2, $collection->first());
    }
    
    public function testContainsMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $this->assertFalse($collection->contains(5));
        $collection->add(5);
        $this->assertTrue($collection->contains(5));
    }

    public function testGetKeysMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $this->assertEquals([], $collection->getKeys());

        $collection->add(5);
        $collection->set(3, 5);

        $this->assertEquals([0, 3], $collection->getKeys());
    }

    public function testSearchMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $this->assertFalse($collection->search(5));

        $collection->add(5);
        $collection->set(3, 4);

        $this->assertEquals(0, $collection->search(5));
        $this->assertEquals(3, $collection->search(4));

        $collection->add(5);

        $this->assertEquals(0, $collection->search(5));
    }

    public function testSearchAllMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $collection->merge([5, 2, 3, 2, 2]);

        $this->assertEquals([1, 3, 4], $collection->searchAll(2));
    }

    public function testDeleteMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $collection->merge([5, 2, 3, 2, 2]);
        $collection->delete(2);

        $this->assertEquals([0 => 5, 2 => 3], $collection->getItems());
    }

    public function testDeleteFreshMethod(): void
    {
        $collection = new Collection(Type::INTEGER);

        $collection->merge([5, 2, 3, 2, 2]);
        $collection->deleteFresh(2);

        $this->assertEquals([5, 3], $collection->getItems());
    }

    public function testCountMethod(): void
    {
        $collection = new Collection(Type::INTEGER);
        
        $this->assertEquals(0, $collection->count());

        $collection->add(1);
        $collection->merge([2, 3]);

        $this->assertEquals(3, $collection->count());
    }
}
