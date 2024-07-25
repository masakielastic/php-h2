<?php

namespace h2\Test;

use PHPUnit\Framework\TestCase;
use h2\HeadersFrame;

class FrameTest extends TestCase {
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
            HeadersFrame::FLAG_END_STREAM,
            HeadersFrame::FLAG_END_HEADERS
       ];

        $frame = new HeadersFrame($streamId, $headers, $flags);
        $ret = bin2hex($frame->getBytes());
        $expect = "00003a01050000000100073a6d6574686f640347455400053a70617468012f00073a736368656d650468747470000a3a617574686f72697479096c6f63616c686f7374";
        $this->assertSame($expect, $ret);
    }
}
