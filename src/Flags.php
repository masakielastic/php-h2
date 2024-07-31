<?php

namespace h2;

class Flags {
    // Data Frame
    const DataEndStream = 0x1;
    const DataPadded = 0x8;

    // Headers Frame
    const HeadersEndStream  = 0x1;
    const HeadersEndHeaders = 0x4;
    const HeadersPadded     = 0x8;
    const HeadersPriority   = 0x20;

    // Settings Frame
    const SettingsAck = 0x1;
}
