<?php

namespace h2;

class Frame {
    string $bytes;

    public static function fromBytes(string $bytes)
    {
        $this->$bytes = $bytes
    }
}
