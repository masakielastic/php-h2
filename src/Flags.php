<?php

namespace h2;

class Flags {
    // Data Frame
    const DATA_END_STREAM = 0x1;
    const DATA_PADDED     = 0x8;

    // Headers Frame
    const HEADERS_END_STREAM  = 0x1;
    const HEADERS_END_HEADERS = 0x4;
    const HEADERS_PADDED      = 0x8;
    const HEADERS_PRIORITY    = 0x20;

    // Settings Frame
    const SETTINGS_ACK = 0x1;
}
