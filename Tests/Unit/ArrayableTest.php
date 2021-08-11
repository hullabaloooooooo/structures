<?php

namespace Tests\Unit;

use Phox\Structures\Abstracts\Arrayable;
use Phox\Structures\Exceptions\ArrayException;
use PHPUnit\Framework\TestCase;

class ArrayableTest extends TestCase
{
    protected function getAnonymousArrayable(array $initial = []): Arrayable
    {
        return new class($initial) extends Arrayable {
            public function __construct(protected array $items) {}
        };
    }

    public function testArrayAccess(): void
    {
        $arrayable = $this->getAnonymousArrayable([5, 2, 6]);
        $arrayable[4] = 66;
        $arrayable[] = 22;

        $this->assertEquals(2, $arrayable[1]);
        $this->assertEquals(66, $arrayable[4]);
        $this->assertEquals(22, $arrayable[5]);
    }

    public function testGet(): void
    {
        $arrayable = $this->getAnonymousArrayable([2, 3]);

        $this->assertEquals(2, $arrayable->get(0));
        $this->assertEquals(3, $arrayable->get(1));

        $this->expectException(ArrayException::class);
        $arrayable->get(2);
    }

    public function testReplace(): void
    {
        $arrayable = $this->getAnonymousArrayable([2, 3]);

        $oldValue = $arrayable->replace(1, 5);

        $this->assertEquals(5, $arrayable->get(1));
        $this->assertEquals(3, $oldValue);
    }

    public function testSet(): void
    {
        $arrayable = $this->getAnonymousArrayable();

        $arrayable->set(3, 8);

        $this->assertEquals(8, $arrayable->get(3));
    }

    public function testExistsSet(): void
    {
        $arrayable = $this->getAnonymousArrayable([1]);

        $this->expectException(ArrayException::class);

        $arrayable->set(0, 2);
    }

    public function testAdd(): void
    {
        $arrayable = $this->getAnonymousArrayable([1]);

        $arrayable->add(5);

        $this->assertEquals(5, $arrayable->get(1));
    }

    public function testHas(): void
    {
        $arrayable = $this->getAnonymousArrayable([1]);

        $this->assertTrue($arrayable->has(0));
        $this->assertFalse($arrayable->has(1));
    }

    public function testRemove(): void
    {
        $arrayable = $this->getAnonymousArrayable([1, 2]);

        $arrayable->remove(1);

        $this->assertFalse($arrayable->has(1));
    }
}
