<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\events;

class Voice extends Event
{
    public function isValid()
    {
        return 'voice' === $this['MsgType'];
    }
}
