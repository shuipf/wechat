<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class Text extends Event
{
    public function isValid()
    {
        return 'text' === $this['MsgType'];
    }
}
