<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class UserLocation extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('LOCATION' === $this['Event']);
    }
}
