<?php

namespace Shuipf\Wechat\Event\Event;

use Shuipf\Wechat\Event\Event;

class Image extends Event
{
    public function isValid()
    {
        return 'image' === $this['MsgType'];
    }
}
