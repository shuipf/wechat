<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class Link extends Event
{
    public function isValid()
    {
        return 'link' === $this['MsgType'];
    }
}
