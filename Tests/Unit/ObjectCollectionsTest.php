<?php

namespace Tests\Unit;

use Phox\Structures\Exceptions\StructureTypeException;
use Phox\Structures\ObjectCollection;
use PHPUnit\Framework\TestCase;

class ObjectCollectionsTest extends TestCase
{
    public function testCannotCreateObjectCollectionWithNoObjectType(): void
    {
        $this->expectException(StructureTypeException::class);

        new ObjectCollection('string');
    }

    public function testCreationObjectCollections(): void
    {
        $objectCollection = new ObjectCollection(static::class);

        $this->assertTrue($objectCollection->allows($this));
    }
    
    public function testHasObjectClassMethod(): void
    {
        $objectCollection = new ObjectCollection(TestCase::class);

        $objectCollection->add($this);

        $this->assertFalse($objectCollection->hasObjectClass(TestCase::class));
        $this->assertTrue($objectCollection->hasObjectClass(static::class));
    }
}