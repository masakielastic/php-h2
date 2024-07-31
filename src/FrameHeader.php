<?php

class FrameHeader {

    private $bytes;

    public function __construct(string $bytes)
    {
        $this->bytes = $bytes;
    }

    public static function from(int $length, int $type, int $streamId, array $flags = [])
    {
        $bytes = static::lengthString($length).chr($type).
                 static::flagString($flags).static::idString($streamId);
        return new static($bytes);
    }

    private static function lengthString(int $length): string
    {
        return match(true) {
            0x100 > $length => "\x00\x00",
            0x10000 > $length => "\x00",
            default => ""
        }.chr($length);
    }

    private static function flagString(array $flags): string
    {
        $flag = 0x0;

        if (count($flags)) {
            foreach ($flags as $value) {
                $flag += $value;
            }
        }

        return pack("c", $flag);
    }

    private static function idString(int $id): string
    {
        return match(true) {
            0x100 > $id => "\x00\x00\x00",
            0x10000 > $id => "\x00\x00",
            0x1000000 > $id => "\x00",
            default => ""
        }.chr($id);
    }

    public function getBytes(): string
    {
        return $this->bytes;
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
