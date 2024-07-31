<?php

namespace h2;
use h2\Frame;
use h2\DataFrame;
use h2\HeadersFrame;
use h2\SettingsFrame;

class FrameIterator implements \IteratorAggregate {

    public function __construct(private string $bytes)
    {
    }

    public function getIterator(): \Generator
    {
        foreach ($this->getByteIterator() as $index => $bytes) {
            yield $index => $this->buildFrame($bytes);
        }
    }

    public function getByteIterator(): \Generator
    {
        $bytesSize = strlen($this->bytes);
        $index = 0;
        $current = 0;
        $next = 0;

        while (true) {
            if ($next >= $bytesSize) {
                break;
            }

            $size = hexdec(bin2hex(substr($this->bytes, $next, 3))) + 9;
            $next += $size;
            yield $index => substr($this->bytes, $current, $size);
            $current = $next;
            ++$index;
        }
    }

    private function buildFrame(string $chunk)
    {
        $type = ord(substr($chunk, 3, 1));

        return match ($type) {
            0x0 => new DataFrame($chunk),
            0x1 => new HeadersFrame($chunk),
            0x4 => new SettingsFrame($chunk),
            default => new Frame($chunk)
        };
    }
}
