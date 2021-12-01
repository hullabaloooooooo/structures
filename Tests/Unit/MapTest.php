<?php


use Phox\Structures\Map;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{

    public function testGet(): void
    {
        $map = new Map(TestCase::class, 'object');

        $obj = new stdClass();
        $map->set($this, $obj);

        $this->assertSame($map->get($this), $obj);
    }

    public function testRemove(): void
    {
        $map = new Map(TestCase::class, 'object');

        $map->set($this, new stdClass());
        $map->remove($this);

        $this->assertFalse($map->has($this));
    }

    public function testHas(): void
    {
        $map = new Map('array', 'string');

        $map->set([1, 2, 3], 'tested');

        $this->assertTrue($map->has([1, 2, 3]));
    }

    public function testSet(): void
    {
        $map = new Map('array', 'string');

        $map->set([1, 2, 3], 'tested');

        $this->assertEquals('tested', $map->get([1, 2, 3]));
    }

    public function testAllows(): void
    {
        $cases = [
            'integer' => 1,
            'string' => 'test',
            'array' => [],
            'object' => new stdClass(),
            TestCase::class => $this,
        ];

        foreach ($cases as $keyType => $keyValue) {
            foreach ($cases as $valueType => $value) {
                $map = new Map($keyType, $valueType);

                $this->assertTrue($map->allowsKey($keyValue));
                $this->assertTrue($map->allows($value));
            }
        }
    }

    public function testReplace(): void
    {
        $map = new Map(stdClass::class, TestCase::class);

        $key = new stdClass();
        $mock = $this->createMock(static::class);
        $map->set($key, $mock);

        $this->assertSame($mock, $map->get($key));

        $map->replace($key, $this);

        $this->assertSame($this, $map->get($key));
    }

    public function testArrayAccess(): void
    {
        $map = new Map(TestCase::class, 'object');

        $obj = new stdClass();
        $map[$this] = $obj;

        $this->assertSame($obj, $map[$this]);
    }
}
