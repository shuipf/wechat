<?php
// +----------------------------------------------------------------------
// | EventHandlerInterface 事件处理器接口
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event;

interface EventHandlerInterface
{
    /**
     * 请求事件处理
     * @param EventListenerInterface $listener
     */
    public function handle(EventListenerInterface $listener);
}
