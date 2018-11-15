<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\events;

class Location extends Event
{
    public function isValid()
    {
        return 'location' === $this['MsgType'];
    }
}
