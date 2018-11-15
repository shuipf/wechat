<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\events;

class Link extends Event
{
    public function isValid()
    {
        return 'link' === $this['MsgType'];
    }
}
