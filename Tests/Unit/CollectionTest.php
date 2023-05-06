<?php

namespace Tests\Unit;

use Phox\Structures\Abstracts\ObjectType;
use Phox\Structures\DepthKey;
use Phox\Structures\Interfaces\IGenerative;
use Phox\Structures\Operator;
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
        $objectCollection = new Collection(Type::Object);

        $this->assertTrue($collection->allows($this));
        $this->assertFalse($collection->allows(new stdClass()));

        $this->assertTrue($objectCollection->allows($this));
        $this->assertTrue($objectCollection->allows(new stdClass()));
    }

    public function testTryGetMethod(): void
    {
        $collection = new Collection(Type::String);

        $collection->set(5, 'value 5');

        $this->assertEquals('value 5', $collection->tryGet(5));
        $this->assertNull($collection->tryGet(1));
        $this->assertEquals('value 1', $collection->tryGet(1, 'value 1'));
    }

    public function testMergeMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $collection->add(2);
        $collection->add(5);
        $collection->merge([4, 3]);
        
        $this->assertEquals([2, 5, 4, 3], $collection->getItems());
        $this->expectException(StructureTypeException::class);

        $collection->merge([7, 'hello']);
    }

    public function testCollectMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $collection->collect(1, 2, 3);
        $this->assertEquals([1, 2, 3], $collection->getItems());

        $collection->collect([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $collection->getItems());

        $collection->collect([1, 2, 3], 4, [5, 6], 7, 8);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8], $collection->getItems());
    }

    public function testFirstMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $this->assertNull($collection->first());

        $collection->collect(5, 2, 3, 1);
        $this->assertEquals(5, $collection->first());

        $collection->delete(5);
        $this->assertEquals(2, $collection->first());
    }
    
    public function testContainsMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $this->assertFalse($collection->contains(5));
        $collection->add(5);
        $this->assertTrue($collection->contains(5));
    }

    public function testGetKeysMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $this->assertEquals([], $collection->getKeys());

        $collection->add(5);
        $collection->set(3, 5);

        $this->assertEquals([0, 3], $collection->getKeys());
    }

    public function testSearchMethod(): void
    {
        $collection = new Collection(Type::Integer);

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
        $collection = new Collection(Type::Integer);

        $collection->merge([5, 2, 3, 2, 2]);

        $this->assertEquals([1, 3, 4], $collection->searchAll(2));
    }

    public function testDeleteMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $collection->merge([5, 2, 3, 2, 2]);
        $collection->delete(2);

        $this->assertEquals([0 => 5, 2 => 3], $collection->getItems());
    }

    public function testDeleteFreshMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $collection->merge([5, 2, 3, 2, 2]);
        $collection->deleteFresh(2);

        $this->assertEquals([5, 3], $collection->getItems());
    }

    public function testCountMethod(): void
    {
        $collection = new Collection(Type::Integer);
        
        $this->assertEquals(0, $collection->count());

        $collection->add(1);
        $collection->merge([2, 3]);

        $this->assertEquals(3, $collection->count());
    }

    public function testMapMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $collection->add(5);

        $mapped = $collection->map(fn(): string => 'hello', Type::String);

        $this->assertEquals('hello', $mapped->first());
    }

    public function testFilterMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $collection->collect([1, 2, 3, 4, 5, 6]);
        $filtered = $collection->filter(fn(int $item): bool => $item > 3);

        $this->assertCount(3, $filtered);

        foreach ([4, 5, 6] as $value) {
            $this->assertContains($value, $filtered);
        }
    }

    public function testGenerativeReturnsStatic(): void
    {
        $collection = new class(Type::Integer) extends Collection {};
        $collection->collect(1, 2, 3, 4);

        $this->assertInstanceOf(IGenerative::class, $collection);

        $newCollection = $collection->filter(fn() => true);
        $this->assertEquals($collection::class, $newCollection::class);

        $newMappedCollection = $newCollection->map(fn(): bool => true, Type::Boolean);
        $this->assertEquals($collection::class, $newMappedCollection::class);
        $this->assertEquals(Type::Boolean, $newMappedCollection->getType());
    }

    public function testGenerativeSaveKeys(): void
    {
        $data = [
            5 => 1,
            1 => 2,
            99 => 3,
        ];

        $collection = new Collection(Type::Integer);

        foreach ($data as $key => $value) {
            $collection->set($key, $value);
        }

        $filteredCollection = $collection->filter(fn() => true, true);
        $mappedCollection = $collection->map(fn($item) => $item, keepKeys: true);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $filteredCollection->get($key));
            $this->assertEquals($value, $mappedCollection->get($key));
        }
    }

    public function testEachMethod(): void
    {
        $collection = new Collection(Type::Integer);

        $mock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['test'])
            ->getMock();
        $mock->expects($this->exactly(4))->method('test');

        $collection->collect(1, 1, 1, 1);

        $collection->each([$mock, 'test']);

        $collection->each(function (int &$item) {
            $item = 2;
        });
        $this->assertEquals([2, 2, 2, 2], $collection->getItems());
    }

    public function testSimpleWhere(): void
    {
        $collection = new Collection(Type::Integer);

        $collection->merge([1, 2, 3, 4, 5, 6]);

        $this->assertEquals([3], $collection->where(Operator::Equal, 3)->toArray());
        $this->assertEquals([5, 6], $collection->where(Operator::GreaterThan, 4)->toArray());
        $this->assertEquals([4, 5, 6], $collection->where(Operator::GreaterThanOrEqual, 4)->toArray());
        $this->assertEquals([1, 2], $collection->where(Operator::LessThan, 3)->toArray());
        $this->assertEquals([1, 2, 3], $collection->where(Operator::LessThanOrEqual, 3)->toArray());
        $this->assertEquals([2, 4], $collection->where(Operator::In, [2, 4, 7])->toArray());
    }

    public function testWhereWithKeys(): void
    {
        $collection = new Collection(Type::Array);

        $collection->merge([
            ['key1' => 'value1', 'key2' => 'value2'],
            ['key1' => 'value3', 'key2' => 'value4'],
            ['key1' => 'value1', 'key2' => 'value5'],
        ]);

        $this->assertEquals([
            ['key1' => 'value1', 'key2' => 'value2'],
            ['key1' => 'value1', 'key2' => 'value5'],
        ], $collection->where(Operator::Equal, 'value1', 'key1')->toArray());

        $this->assertEquals([
            ['key1' => 'value1', 'key2' => 'value2'],
        ], $collection->where(Operator::Equal, 'value2', 'key2')->toArray());

        $this->assertEquals(
            [
                ['key1' => 'value1', 'key2' => 'value5'],
            ],
            $collection->where(Operator::Equal, 'value1', 'key1')
                ->where(Operator::Equal, 'value5', 'key2')
                ->toArray(),
        );
    }

    public function testWhereWithObjects(): void
    {
        $collection = new Collection(Type::Object);

        $collection->merge([
            (object)['key1' => 'value1', 'key2' => 'value2'],
            (object)['key1' => 'value3', 'key2' => 'value4'],
            (object)['key1' => 'value1', 'key2' => 'value5'],
        ]);

        $this->assertEquals([
            (object)['key1' => 'value1', 'key2' => 'value2'],
            (object)['key1' => 'value1', 'key2' => 'value5'],
        ], $collection->where(Operator::Equal, 'value1', 'key1')->toArray());

        $this->assertEquals([
            (object)['key1' => 'value1', 'key2' => 'value2'],
        ], $collection->where(Operator::Equal, 'value2', 'key2')->toArray());

        $this->assertEquals(
            [
                (object)['key1' => 'value1', 'key2' => 'value5'],
            ],
            $collection->where(Operator::Equal, 'value1', 'key1')
                ->where(Operator::Equal, 'value5', 'key2')
                ->toArray(),
        );
    }

    public function testWhereWithDepthKey(): void
    {
        $collection = new Collection(Type::Object);

        $collection->merge([
            (object)['key1' => 'value1', 'key2' => ['subKey' => 'value2']],
            (object)['key1' => 'value1', 'key2' => ['subKey' => 'value3']],
            (object)['key1' => 'value1', 'key2' => ['subKey' => 'value4']],
        ]);

        $this->assertEquals(
            [(object)['key1' => 'value1', 'key2' => ['subKey' => 'value3']]],
            $collection->where(Operator::Equal, 'value3', new DepthKey('key2.subKey'))->toArray(),
        );
    }

    public function testSelectMethod(): void
    {
        $collection = new Collection(Type::Array);

        $collection->join([
            10 => ['key1' => 'value1', 'key2' => ['subKey' => 'value2']],
            11 => ['key1' => 'value1', 'key2' => ['subKey' => 'value3']],
            12 => ['key1' => 'value1', 'key2' => ['subKey' => 'value4']],
        ], true);

        $this->assertEquals(
            ['value1', 'value1', 'value1'],
            $collection->select('key1', Type::String)->toArray(),
        );

        $this->assertEquals(
            [
                10 => 'value1',
                11 => 'value1',
                12 => 'value1',
            ],
            $collection->select('key1', Type::String, true)->toArray(),
        );

        $this->assertEquals(
            [
                10 => 'value2',
                11 => 'value3',
                12 => 'value4',
            ],
            $collection->select(new DepthKey('key2.subKey'), Type::String, true)->toArray(),
        );

        $this->expectException(StructureTypeException::class);

        $collection->select('key1');
    }
}
