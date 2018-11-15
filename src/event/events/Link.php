<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class Link extends Event
{
    public function isValid()
    {
        return 'link' === $this['MsgType'];
    }
}
