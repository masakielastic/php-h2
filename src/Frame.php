<?php

namespace h2;

class Frame {
    private $bytes;

    public function __construct(string $bytes)
    {
        $this->bytes = $bytes;
    }

    public function getBytes(): string
    {
        return $this->bytes;
    }
}
