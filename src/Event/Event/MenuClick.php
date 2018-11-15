<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class MenuClick extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('CLICK' === $this['Event']);
    }
}
