<?php

namespace h2;

class HeadersFrame extends Frame {

    public static function from(string $payload, int $streamId, array $flags = []): static
    {
         $header = static::frameHeader(strlen($payload), 0x1, $streamId, $flags);
         return new static($header.$payload);
    }

    public static function fromRawHeaders(array $headers, int $streamId, array $flags = []): static
    {
        $payload = static::getPayloadFromRawHeaders($headers);
        $header = static::frameHeader(strlen($payload), 0x1, $streamId, $flags);
        return new static($header.$payload);
    }

    protected static function getPayloadFromRawHeaders(array $headers): string
    {
        $payload = '';

        foreach ($headers as $header) {
             $name = pack("c", strlen($header[0])).$header[0];
             $value = pack("c", strlen($header[1])).$header[1];
             $payload .= chr(0x0).$name.$value;
        }

        return $payload;
    }
}
