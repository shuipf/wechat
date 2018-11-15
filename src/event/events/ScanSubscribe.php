<?php
// +----------------------------------------------------------------------
// | ScanSubscribe 扫描二维码关注事件
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event\events;

use shuipf\wechat\event\Event;

class ScanSubscribe extends Event
{
    /**
     * 扫描带参数的二维码时，提交参数格式为 "qrscene_参数值"，
     * 为了方便获取参数值，手动添加了一个参数叫 "EventKeyValue"
     * 该参数仅在 EventScanSubscribe 和 EventScanSubscribed 事件中可用.
     * ScanSubscribe constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    /**
     * 是否扫描二维码关注事件
     * @return bool
     */
    public function isValid()
    {
        return ('event' === $this['MsgType'])
            && ('subscribe' === $this['Event'])
            && !empty($this['EventKey']);
    }
}
