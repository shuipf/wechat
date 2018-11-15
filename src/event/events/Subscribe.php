<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class Subscribe extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('subscribe' === $this['Event'])
            && empty($this['EventKey']);
    }
}
