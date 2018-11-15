<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class Location extends Event
{
    public function isValid()
    {
        return 'location' === $this['MsgType'];
    }
}
