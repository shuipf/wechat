<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class Unsubscribe extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('unsubscribe' === $this['Event']);
    }
}
