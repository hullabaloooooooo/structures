<?php

namespace Tests\Unit;

use Phox\Structures\Collection;
use Phox\Structures\Exceptions\CollectionTypeException;
use PHPUnit\Framework\TestCase;
use stdClass;

class CollectionTest extends TestCase
{
    public function testAllows(): void
    {
        $collection = new Collection(CollectionTest::class);

        $this->expectException(CollectionTypeException::class);

        $collection->add(1);
    }

    public function testCollectionAllowSameType(): void
    {
        $collection = new Collection(TestCase::class);
        $objectCollection = new Collection('object');

        $this->assertTrue($collection->allows($this));
        $this->assertFalse($collection->allows(new stdClass()));

        $this->assertTrue($objectCollection->allows($this));
        $this->assertTrue($objectCollection->allows(new stdClass()));
    }

    public function testTryGetMethod(): void
    {
        $collection = new Collection('string');

        $collection->set(5, 'value 5');

        $this->assertEquals('value 5', $collection->tryGet(5));
        $this->assertNull($collection->tryGet(1));
        $this->assertEquals('value 1', $collection->tryGet(1, 'value 1'));
    }

    public function testGetTypeMethod(): void
    {
        $collection = new Collection(static::class);

        $this->assertEquals(static::class, $collection->getType());
    }
}
