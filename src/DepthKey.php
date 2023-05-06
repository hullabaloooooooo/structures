<?php

namespace Phox\Structures;

readonly class DepthKey
{
    public function __construct(
        public string $key,
        public string $delimiter = '.',
    ) {
    }

    /**
     * @return array<string>
     */
    public function getPath(): array
    {
        return explode($this->delimiter, $this->key);
    }
}