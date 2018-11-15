<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class ShortVideo extends Event
{
    public function isValid()
    {
        return 'shortvideo' === $this['MsgType'];
    }
}
