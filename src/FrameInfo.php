<?php

namespace h2;

class FrameInfo {

    private $byte;

    public function __construct(string $bytes)
    {
        $this->bytes = $bytes;
    }


    public function getLength()
    {
        return hexdec(bin2hex(substr($this->bytes, 0, 3)));
    }

    public function getType()
    {
        return ord(substr($this->bytes, 3, 1));
    }

     public function getFlag()
     {
         return ord(substr($this->bytes, 4, 1));
     }
}
