<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class Subscribe extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('subscribe' === $this['Event'])
            && empty($this['EventKey']);
    }
}
