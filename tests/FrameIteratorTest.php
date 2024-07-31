<?php

namespace h2\Test;

use PHPUnit\Framework\TestCase;
use h2\HeadersFrame;
use h2\SettingsFrame;
use h2\Flags;

class FrameIteratorTest extends TestCase {

    public function request($key = null): string
    {
        $headers = [
            [':method', 'GET'],
            [':path', '/'],
            [':scheme', 'http'],
            [':authority', 'localhost']
        ];

        $flags = [
            Flags::HeadersEndStream,
            Flags::HeadersEndHeaders
        ];

        $ret = [
            'settings' => SettingsFrame::from()->getBytes(),
            'ack' => SettingsFrame::from([Flags::SettingsAck])->getBytes(),
            'headers' => HeadersFrame::fromRawHeaders($headers, 0x1, $flags)->getBytes()
        ];

        return empty($key) ? implode($ret) : $ret[$key];
    }

    public function testFrameIterator()
    {
        $iter = new FrameIterator(request());
        $ret = [];

        foreach ($iter as $index => $frame) {
            $ret[] = $frame->getBytes();
        }

        $this->assertSame(request('settings'), $ret[0]);
        $this->assertSame(request('ack'), $ret[1]);
        $this->assertSame(request('headers'), $ret[2]);
    }
}
