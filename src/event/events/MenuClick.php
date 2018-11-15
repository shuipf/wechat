<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class MenuClick extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('CLICK' === $this['Event']);
    }
}
