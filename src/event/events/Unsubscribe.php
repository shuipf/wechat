<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class Unsubscribe extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('unsubscribe' === $this['Event']);
    }
}
