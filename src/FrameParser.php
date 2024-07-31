<?php

namespace h2;
use h2\Frame;

class FrameParser implements \IteratorAggregate {

    public function __construct(private string $bytes)
    {
    }

    public function getIterator(): \Generator
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
            yield $index => $this->buildFrame(substr($this->bytes, $current, $size));
            $current = $next;
            ++$index;
        }
    }

    public function buildFrame(string $chunk)
    {
        new Frame($chunk);
    }
}
