<?php

namespace h2;

class FrameByteIterator implements \IteratorAggregate {

    public function __construct(private string $bytes)
    {
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
}
