<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\events;

class Image extends Event
{
    public function isValid()
    {
        return 'image' === $this['MsgType'];
    }
}
