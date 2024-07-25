<?php

namespace h2;

use h2\DataFrame;

class FrameWriter implements \IteratorAggregate {
    public $bytes = "";
    public $frames = [];

    public function getIterator(): \Generator
    {
        $index = 0;
        foreach ($this as $index => $frame) {
            yield $frame;
            ++$index;
        }
    }

    function writeHeadersFrame(int $streamId, array $headers, array $flags = [])
    {
        $this->frames[] = new HeadersFrame($streamId, $headers, $flags);
    }

    function getFrames() {
        return $this->frames;
    }
}
