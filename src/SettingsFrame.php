<?php

class SettingsFrame extends Frame {

    public static function from(array $flags = [])
    {
        $bytes = FrameHeader::from(0x0, 0x4, 0x0, $flags)->getBytes();
        return new static($bytes);
    }
}
