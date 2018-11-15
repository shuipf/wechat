<?php
// +----------------------------------------------------------------------
// | Location 地理位置消息事件
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class Location extends Event
{
    /**
     * 是否地理位置消息事件
     * @return bool
     */
    public function isValid()
    {
        return 'location' === $this['MsgType'];
    }
}
