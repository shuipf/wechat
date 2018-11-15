<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\events;

class Text extends Event
{
    public function isValid()
    {
        return 'text' === $this['MsgType'];
    }
}
