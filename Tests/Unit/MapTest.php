<?php

use JetBrains\PhpStorm\ArrayShape;
use Phox\Structures\Map;
use PHPUnit\Framework\TestCase;
use Phox\Structures\Abstracts\Type;
use Phox\Structures\Abstracts\ObjectType;

class MapTest extends TestCase
{

    public function testGet(): void
    {
        $map = new Map(ObjectType::fromClass(TestCase::class), Type::OBJECT);

        $obj = new stdClass();
        $map->set($this, $obj);

        $this->assertSame($map->get($this), $obj);
    }

    public function testRemove(): void
    {
        $map = new Map(ObjectType::fromClass(TestCase::class), Type::OBJECT);

        $map->set($this, new stdClass());
        $map->remove($this);

        $this->assertFalse($map->has($this));
    }

    public function testHas(): void
    {
        $map = new Map(Type::ARRAY, Type::STRING);

        $map->set([1, 2, 3], 'tested');

        $this->assertTrue($map->has([1, 2, 3]));
    }

    public function testSet(): void
    {
        $map = new Map(Type::ARRAY, Type::STRING);

        $map->set([1, 2, 3], 'tested');

        $this->assertEquals('tested', $map->get([1, 2, 3]));
    }

    public function testAllows(): void
    {
        $cases = [
            ['type' => Type::INTEGER, 'value' => 1],
            ['type' => Type::STRING, 'value' => 'test'],
            ['type' => Type::ARRAY, 'value' => []],
            ['type' => Type::OBJECT, 'value' => new stdClass()],
            ['type' => ObjectType::fromClass(TestCase::class), 'value' => $this],
        ];

        foreach ($cases as $key) {
            foreach ($cases as $value) {
                $map = new Map($key['type'], $value['type']);

                $this->assertTrue($map->allowsKey($key['value']));
                $this->assertTrue($map->allows($value['value']));
            }
        }
    }

    public function testReplace(): void
    {
        $map = new Map(ObjectType::fromClass(stdClass::class), ObjectType::fromClass(TestCase::class));

        $key = new stdClass();
        $mock = $this->createMock(static::class);
        $map->set($key, $mock);

        $this->assertSame($mock, $map->get($key));

        $map->replace($key, $this);

        $this->assertSame($this, $map->get($key));
    }

    public function testArrayAccess(): void
    {
        $map = new Map(ObjectType::fromClass(TestCase::class), Type::OBJECT);

        $obj = new stdClass();
        $map[$this] = $obj;

        $this->assertSame($obj, $map[$this]);
    }
}
