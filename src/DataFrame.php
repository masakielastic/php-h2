<?php

namespace h2;

class DataFrame extends Frame {

    public static function from(string $data, int $streamId, array $flags = [])
    {
        $header = FrameHeader::from(strlen($data), 0x0, $streamId, $flags)->getBytes();
        return new static($header.$data);
    }
}
