<?php

class SettingsFrame extends Frame {

    public static function from()
    {
        $bytes = FrameHeader::from(0x0, 0x4, 0x0)->getBytes();
        return new static($bytes);
    }
}
