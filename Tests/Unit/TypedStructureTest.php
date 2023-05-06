<?php

namespace Tests\Unit;

use Phox\Structures\Abstracts\IntersectionType;
use Phox\Structures\Abstracts\NullableType;
use Phox\Structures\Abstracts\Type;
use Phox\Structures\Abstracts\UnionType;
use Phox\Structures\Collection;
use Phox\Structures\EnumerableArray;
use Phox\Structures\Interfaces\IArray;
use Phox\Structures\Interfaces\IEnumerable;
use Phox\Structures\Interfaces\IGenerative;
use PHPUnit\Framework\TestCase;

class TypedStructureTest extends TestCase
{
    public function testNullableTypes(): void
    {
        $collection = new Collection(NullableType::from(Type::Integer));

        $this->assertTrue($collection->allows(null));

        $collectionType = $collection->getType();
        $this->assertTrue($collectionType->allowsType(Type::Integer));
        $this->assertTrue($collectionType->allowsType(Type::Null));

        $collection->add(null);
        $this->assertNull($collection->first());
    }

    public function testUnionType(): void
    {
        $collection = new Collection(UnionType::from([
            Type::String,
            Type::Integer,
        ]));

        $this->assertTrue($collection->allows('hello'));
        $this->assertTrue($collection->allows(123));

        $collectionType = $collection->getType();
        $this->assertTrue($collectionType->allowsType(Type::String));
        $this->assertTrue($collectionType->allowsType(Type::Integer));

        $collection->add(564);
        $collection->add('Hello Test!');
    }

    public function testIntersectionType(): void
    {
        $collection =new Collection(IntersectionType::from([
            type(IArray::class),
            type(IEnumerable::class),
            type(IGenerative::class),
        ]));

        $this->assertTrue($collection->allows(new Collection(Type::Integer)));
        $this->assertFalse($collection->allows(new EnumerableArray(Type::Integer)));
    }
}