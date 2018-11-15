<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\events;

class ShortVideo extends Event
{
    public function isValid()
    {
        return 'shortvideo' === $this['MsgType'];
    }
}
