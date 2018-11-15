<?php

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\events;

class MenuView extends Event
{
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('VIEW' === $this['Event']);
    }
}
