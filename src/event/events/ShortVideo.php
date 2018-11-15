<?php
// +----------------------------------------------------------------------
// | ShortVideo 小视频消息事件
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class ShortVideo extends Event
{
    /**
     * 是否小视频消息事件
     * @return bool
     */
    public function isValid()
    {
        return 'shortvideo' === $this['MsgType'];
    }
}
