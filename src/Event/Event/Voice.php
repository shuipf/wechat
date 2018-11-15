<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class Voice extends Event
{
    public function isValid()
    {
        return 'voice' === $this['MsgType'];
    }
}
