<?php

class FrameWriter {
    public $buffer = "";

    function writeHeadersFrame(int $streamId, array $headers, array $flags = [])
    {
        $stream = match(true) {
            0x100 > $streamId => "\x00\x00\x00",
            0x10000 > $streamId => "\x00\x00",
            0x1000000 > $streamId => "\x00",
            default => ""
        }.chr($streamId);

        $payload = "";

        foreach ($headers as $header) {
            $payload .= chr(0x00).pack("c", strlen($header[0])).$header[0].pack("c", strlen($header[1])).$header[1];
        }

        $length = strlen($payload);

        $payloadLength = match(true) {
            0x100 > $length => "\x00\x00",
            0x10000 > $length => "\x00",
            default => ""
        }.chr($length);

        $flag = 0;

        if (count($flags)) {
           foreach ($flags as $value) {
               $flag += $value;
           }
        }

        $this->buffer .= $payloadLength.chr(FrameType::HEADERS).pack("c", $flag).$stream.$payload;
    }
}
