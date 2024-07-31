<?php

namespace h2;
use h2\FrameHeader;

class FrameInfo {

    private $frameHeader;
    private $payload;

    public function __construct(string $bytes)
    {
        $this->frameHeader = new FrameHeader(substr($bytes, 0, 9));
        $this->payload = substr($bytes, 9);
    }


    public function getLength()
    {
        return $frameHeader->getLength();
    }

    public function getType()
    {
        return $frameHeader->getType();
    }

     public function getFlag()
     {
         return $frameHeader->getFlag();
     }
}
