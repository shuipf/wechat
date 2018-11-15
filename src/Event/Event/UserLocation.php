<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class UserLocation extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('LOCATION' === $this['Event']);
    }
}
