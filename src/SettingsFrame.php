<?php

namespace h2;

class SettingsFrame extends Frame {

    public static function from(array $flags = [])
    {
        $bytes = static::frameHeader(0x0, 0x4, 0x0, $flags);
        return new static($bytes);
    }
}
