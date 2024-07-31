<?php

namespace h2;
use h2\frameHeader;

class Frame {
    private $frameHeader;
    private $payload;

    public function __construct(string $bytes)
    {
        $this->frameHeader = new FrameHeader(substr($bytes, 0, 9));
        $this->payload = substr($bytes, 9);
    }

    public function getLength(): int
    {
        return $this->frameHeader->getLength();
    }

    public function getType(): int
    {
        return $this->frameHeader->getType();
    }

    public function getFlag(): int
    {
        return $this->frameHeader->getFlag();
    }

    public function getPayload():string
    {
        return $this->getpayload;
    }

    public function getBytes(): string
    {
        return $this->frameHeader->getBytes().$this->getPayload();
    }
}
