<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class Text extends Event
{
    public function isValid()
    {
        return 'text' === $this['MsgType'];
    }
}
