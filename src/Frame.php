<?php

namespace h2;

class Frame {
    private $bytes;

    function getBytes(): string
    {
        return $this->bytes;
    }

    function fromBytes(string $bytes)
    {
        $this->bytes = $bytes;
    }
}
