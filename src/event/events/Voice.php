<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class Voice extends Event
{
    public function isValid()
    {
        return 'voice' === $this['MsgType'];
    }
}
