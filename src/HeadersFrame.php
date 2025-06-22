<?php

namespace h2;

use Amp\Http\Internal\HPackNghttp2;

class HeadersFrame extends Frame {

    public static function from(string $payload, int $streamId, array $flags = []): static
    {
         $header = static::frameHeader(strlen($payload), 0x1, $streamId, $flags);
         return new static($header.$payload);
    }

    public static function fromRawHeaders(array $headers, int $streamId, array $flags = []): static
    {
        $hpack = new Amp\Http\Internal\HPackNghttp2;
        $payload = $hpack->encode($headers);
        $header = static::frameHeader(strlen($payload), 0x1, $streamId, $flags);
        return new static($header.$payload);
    }
}
