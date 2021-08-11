<?php

namespace Tests\Unit;

use Phox\Structures\Exceptions\CollectionTypeException;
use Phox\Structures\ListedObjectCollection;
use Phox\Structures\ObjectCollection;
use PHPUnit\Framework\TestCase;
use stdClass;

class ObjectCollectionsTest extends TestCase
{
    public function testCannotCreateObjectCollectionWithNoObjectType(): void
    {
        $this->expectException(CollectionTypeException::class);

        new ObjectCollection('string');
    }

    public function testCannotCreateListedObjectCollectionWithNoObjectType(): void
    {
        $this->expectException(CollectionTypeException::class);

        new ListedObjectCollection(gettype([]));
    }

    public function testCreationObjectCollections(): void
    {
        $objectCollection = new ObjectCollection(static::class);
        $this->assertTrue($objectCollection->allows($this));

        $listedObjectCollection = new ListedObjectCollection(stdClass::class);
        $this->assertTrue($listedObjectCollection->allows(new stdClass()));
    }
}