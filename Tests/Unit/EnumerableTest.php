<?php

namespace Tests\Unit;

use Phox\Structures\Abstracts\Enumerable;
use PHPUnit\Framework\TestCase;

class EnumerableTest extends TestCase
{
    protected function getAnonymousEnumerable(): Enumerable
    {
        return new class extends Enumerable {
            protected array $items = [5, 2, 6];
        };
    }

    public function testCanRunEnumerableInLoop(): void
    {
        $enumerable = $this->getAnonymousEnumerable();

        $count = 0;
        foreach ($enumerable as $item) {
            $this->assertIsInt($item);
            $count++;
        }

        $this->assertEquals(3, $count);
    }

    public function testEnumerableCaret(): void
    {
        $enumerable = $this->getAnonymousEnumerable();

        foreach ([5, 2, 6] as $item) {
            $this->assertEquals($item, $enumerable->current());
            $enumerable->next();
        }

        $this->assertFalse($enumerable->current());

        $enumerable->rewind();

        $this->assertEquals(5, $enumerable->current());
    }
}
