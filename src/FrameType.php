<?php

namespace h2;

class FrameType {
    const int DATA          = 0x0;
    const int HEADERS       = 0x1;
    const int PRIORITY      = 0x2;
    const int RSTSTREAM     = 0x3;
    const int SETTINGS      = 0x4;
    const int PUSH_PROMISE  = 0x5;
    const int PING          = 0x6;
    const int GO_AWAY       = 0x7;
    const int WINDOW_UPDATE = 0x8;
    const int CONTINUATION  = 0x9;
}
