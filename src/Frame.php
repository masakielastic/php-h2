<?php

namespace h2;

class Frame {
    private $bytes;

    public function __construct(string $bytes)
    {
        $this->bytes = $bytes;
    }

    public function getLength(): int
    {
        return hexdec(bin2hex(substr($this->bytes, 0, 3)));
    }

    public function getType(): int
    {
        return hexdec(bin2hex(substr($this->bytes, 3, 1)));
    }

    public function getFlag(): int
    {
        return hexdec(bin2hex(substr($this->bytes, 4, 1)));
    }

    public function getPayload(): string
    {
        return substr($this->bytes, 9);
    }

    public function getBytes(): string
    {
        return $this->bytes;
    }

    public function has(int $flag): bool
    {
        return $this->getFlag() === $flag;
    }

    protected static function frameHeader(int $length, int $type, int $streamId, array $flags = []): string
    {
        $bytes = static::lengthString($length).chr($type).
                 static::flagString($flags).static::idString($streamId);
        return $bytes;
    }

    protected static function lengthString(int $length): string
    {
        return match(true) {
            0x100 > $length => "\x00\x00",
            0x10000 > $length => "\x00",
            default => ""
        }.chr($length);
    }

    protected static function flagString(array $flags): string
    {
        $flag = 0x0;

        if (count($flags)) {
            foreach ($flags as $value) {
                $flag += $value;
            }
        }

        return pack("c", $flag);
    }

    protected static function idString(int $id): string
    {
        return match(true) {
            0x100 > $id => "\x00\x00\x00",
            0x10000 > $id => "\x00\x00",
            0x1000000 > $id => "\x00",
            default => ""
        }.chr($id);
    }
}
