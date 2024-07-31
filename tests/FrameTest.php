<?php

namespace h2\Test;

use PHPUnit\Framework\TestCase;
use h2\HeadersFrame;
use h2\SettingsFrame;
use h2\DataFrame;
use h2\Flags;

class FrameTest extends TestCase {
    public function testSettingsFrame()
    {
        $ret = SettingsFrame::from()->getBytes();
        $expect = "\x00\x00\x00\x04\x00\x00\x00\x00\x00";
        $this->assertSame($expect, $ret);
    }

    public function testAck()
    {
        $ret = SettingsFrame::from([Flags::SETTINGS_ACK])->getBytes();
        $expect = "\x00\x00\x00\x04\x01\x00\x00\x00\x00";
        $this->assertSame($expect, $ret);
    }

    public function testHeadersFrame()
    {
        $streamId = 0x01;
        $headers = [
            [':method', 'GET'],
            [':path', '/'],
            [':scheme', 'http'],
            [':authority', 'localhost']
        ];

        $flags = [
            Flags::HEADERS_END_STREAM,
            Flags::HEADERS_END_HEADERS
       ];

        $frame = HeadersFrame::fromRawHeaders($headers, $streamId, $flags);
        $ret = bin2hex($frame->getBytes());
        $expect = "00003a01050000000100073a6d6574686f640347455400053a70617468012f00073a736368656d650468747470000a3a617574686f72697479096c6f63616c686f7374";
        $this->assertSame($expect, $ret);
    }

    public function testDataFrame()
    {
        $ret = DataFrame::from("Hello\n", 0x1, [0x1])->getBytes();
        $expect = "\x00\x00\x06".
                  "\x00".
                  "\x01".
                  "\x00\x00\x00\x01".
                  "\x48\x65\x6c\x6c\x6f\x0a";

        $this->assertSame($expect, $ret);
    }
}
