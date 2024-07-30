<?php

namespace h2;

class FrameParser implements \IteratorAggregate {

    public function __construct(readonly string $src)
    {
    }

    public function getIterator(): \Generator
    {
        $chunk_size = \strlen($this->src);
        $index = 0;
        $next = 0;

        while (true) {
            if ($next > $chunk_size || $next + 3 > $chunk_size) {
                break;
            }

            $size = \hexdec(\bin2hex(\substr($this->src, $next, 3))) + 9;
            $next += $size;

            yield $index => $next;
            ++$index;
        }
    }

}
