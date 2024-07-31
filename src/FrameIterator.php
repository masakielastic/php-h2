<?php

namespace h2;
use h2\FrameByteIterator;
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
        $iter = new FrameByteIterator($this->bytes);

        foreach ($iter as $index => $chunk) {
            yield $index => $this->buildFrame($chunk);
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
