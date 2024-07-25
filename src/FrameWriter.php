<?php

namespace h2;

class FrameWriter implements \IteratorAggregate {
    public $buffer = "";
    public $frames = [];

    function public getIterator():
    {
        $index = 0;
        foreach ($this as $index => $frame) {
            yield $frame;
            ++$index;
        }
    }

    function writeHeadersFrame(int $streamId, array $headers, array $flags = [])
    {
        $this->frames[] = new Dataframe($streamId, $headers, $flags);
    }
}
