<?php

namespace Tests\Unit;

use Phox\Structures\Exceptions\CollectionKeyTypeException;
use Phox\Structures\ListedCollection;
use PHPUnit\Framework\TestCase;

class ListedCollectionTest extends TestCase
{
    public function testReplaceMethodWithBadKey(): void
    {
        $collection = new ListedCollection('string');

        $this->expectException(CollectionKeyTypeException::class);

        $collection->replace('someKey', 'value');
    }

    public function testGetMethodWithBadKey(): void
    {
        $collection = new ListedCollection('string');

        $this->expectException(CollectionKeyTypeException::class);

        $collection->get('someKey');
    }

    public function testTryGetMethodWithBadKey(): void
    {
        $collection = new ListedCollection('string');

        $this->expectException(CollectionKeyTypeException::class);

        $collection->tryGet('someKey');
    }

    public function testMethodsGetAndReplace(): void
    {
        $collection = new ListedCollection('string');

        $collection->replace(5, 'value 5');

        $this->assertEquals('value 5', $collection->get(5));
    }
}