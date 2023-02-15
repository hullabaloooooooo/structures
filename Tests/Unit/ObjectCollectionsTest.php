<?php

namespace Tests\Unit;

use Phox\Structures\Abstracts\ObjectType;
use PHPUnit\Framework\TestCase;
use Phox\Structures\Abstracts\Type;
use Phox\Structures\ObjectCollection;
use Phox\Structures\Exceptions\StructureTypeException;

class ObjectCollectionsTest extends TestCase
{
    public function testCreationObjectCollections(): void
    {
        $objectCollection = new ObjectCollection(ObjectType::fromClass(static::class));

        $this->assertTrue($objectCollection->allows($this));
    }
    
    public function testHasObjectClassMethod(): void
    {
        $objectCollection = new ObjectCollection(ObjectType::fromClass(TestCase::class));

        $objectCollection->add($this);

        $this->assertFalse($objectCollection->hasObjectClass(TestCase::class));
        $this->assertTrue($objectCollection->hasObjectClass(static::class));
    }
}