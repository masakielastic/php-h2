<?php

namespace h2;

class HeadersFrame extends Frame {

    public static function from(array $headers, int $streamId, array $flags = [])
    {
         $payload = '';

         foreach ($headers as $header) {
             $name = pack("c", strlen($header[0])).$header[0];
             $value = pack("c", strlen($header[1])).$header[1];
             $payload .= chr(0x0).$name.$value;
         }

         $header = FrameHeader::from(strlen($payload), 0x1, $streamId, $flags)->getBytes();
         return new static($header.$payload);
     }
}
