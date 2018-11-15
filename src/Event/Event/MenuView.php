<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class MenuView extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('VIEW' === $this['Event']);
    }
}
