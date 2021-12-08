<?php

namespace Tests\Unit;

use Phox\Structures\Abstracts\ObjectType;
use Phox\Structures\Abstracts\Type;
use TypeError;
use PHPUnit\Framework\TestCase;
use Phox\Structures\ArrayObject;
use Phox\Structures\Exceptions\ArrayException;
use Phox\Structures\Interfaces\IType;

class ArrayableTest extends TestCase
{
    /**
     * @template T
     * @param IType<T> $type
     * @param array<T> $initial
     * @return ArrayObject<T>
     */
    protected function getArrayable(IType $type, array $initial = []): ArrayObject
    {
        $object = new ArrayObject($type);

        foreach ($initial as $item) {
            $object->add($item);
        }

        return $object;
    }

    public function testArrayAccess(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER, [5, 2, 6]);
        $arrayable[4] = 66;
        $arrayable[] = 22;

        $this->assertEquals(2, $arrayable[1]);
        $this->assertEquals(66, $arrayable[4]);
        $this->assertEquals(22, $arrayable[5]);
    }

    public function testStringKeys(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER, [1, 2, 3]);

        $this->expectException(TypeError::class);

        /* @phpstan-ignore-next-line */
        $arrayable->set('index', 123);
    }

    public function testGet(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER, [2, 3]);

        $this->assertEquals(2, $arrayable->get(0));
        $this->assertEquals(3, $arrayable->get(1));

        $this->expectException(ArrayException::class);
        $arrayable->get(2);
    }

    public function testReplace(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER, [2, 3]);

        $arrayable->replace(1, 5);

        $this->assertEquals(5, $arrayable->get(1));
    }

    public function testSet(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER);

        $arrayable->set(3, 8);
        $arrayable->set(null, 5);

        $this->assertEquals(8, $arrayable->get(3));
        $this->assertEquals(5, $arrayable->get(4));
    }

    public function testExistsSet(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER, [1]);

        $this->expectException(ArrayException::class);

        $arrayable->set(0, 2);
    }

    public function testAdd(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER, [1]);

        $arrayable->add(5);

        $this->assertEquals(5, $arrayable->get(1));
    }

    public function testHas(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER, [1]);

        $this->assertTrue($arrayable->has(0));
        $this->assertFalse($arrayable->has(1));
    }

    public function testRemove(): void
    {
        $arrayable = $this->getArrayable(Type::INTEGER, [1, 2]);

        $arrayable->remove(1);

        $this->assertFalse($arrayable->has(1));
    }

    public function testAllowsMethod(): void
    {
        $arrayable = $this->getArrayable(Type::STRING);

        $this->assertTrue($arrayable->allows('teststring'));
        $this->assertFalse($arrayable->allows(1));
    }

    public function testGetTypeMethod(): void
    {
        $arrayable = $this->getArrayable(ObjectType::fromClass(static::class));

        $this->assertEquals(static::class, $arrayable->getType()->getType());
        $this->assertTrue($arrayable->getType()->isSameType(static::class));
    }
}
