<?php
// +----------------------------------------------------------------------
// | Unsubscribe 取消关注事件
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class Unsubscribe extends Event
{
    /**
     * 是否取消关注事件
     * @return bool
     */
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('unsubscribe' === $this['Event']);
    }
}
