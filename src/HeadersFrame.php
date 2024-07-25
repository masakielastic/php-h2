<?php

namespace h2;

use h2\Frame;
use h2\FrameType;

class HeadersFrame extends Frame {
    const int FLAG_END_STREAM = 0x01;
    const int FLAG_END_HEADERS = 0x04;

    public function __construct(int $streamId, array $headers, array $flags = [])
    {
        $stream = match(true) {
            0x100 > $streamId => "\x00\x00\x00",
            0x10000 > $streamId => "\x00\x00",
            0x1000000 > $streamId => "\x00",
            default => ""
        }.chr($streamId);

        $payload = "";

        foreach ($headers as $header) {
            $name = pack("c", strlen($header[0])).$header[0];
            $value = pack("c", strlen($header[1])).$header[1];
            $payload .= chr(0x00).$name.$value;
        }

        $length = strlen($payload);

        $payloadLength = match(true) {
            0x100 > $length => "\x00\x00",
            0x10000 > $length => "\x00",
            default => ""
        }.chr($length);

        $flag = 0x00;

        if (count($flags)) {
           foreach ($flags as $value) {
               $flag += $value;
           }
        }

        $type = chr(FrameType::HEADERS);
        $flag = pack("c", $flag);
        $this->bytes = $payloadLength.$type.$flag.$stream.$payload;
    }
}
