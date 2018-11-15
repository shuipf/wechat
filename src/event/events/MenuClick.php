<?php
// +----------------------------------------------------------------------
// | MenuClick 自定义菜单点击拉取消息事件
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class MenuClick extends Event
{
    /**
     * 是否自定义菜单点击拉取消息事件
     * @return bool
     */
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('CLICK' === $this['Event']);
    }
}
