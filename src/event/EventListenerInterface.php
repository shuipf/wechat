<?php
// +----------------------------------------------------------------------
// | EventListenerInterface 监听器接口
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event;

interface EventListenerInterface
{
    /**
     * 触发事件
     * @param $handler
     * @param Event $event
     * @return mixed
     */
    public function trigger($handler, Event $entity);

    /**
     * 添加监听
     * @param string $handler 事件类型，类名
     * @param callable $callable 回调
     * @return $this
     */
    public function addListener($handler, callable $callable);

    /**
     * 获取指定监听事件
     * @param string $handler 事件类型，类名
     * @return callable 回调
     */
    public function getListener($handler);

    /**
     * 判断该监听事件是否存在
     * @param string $handler 事件类型，类名
     * @return bool
     */
    public function hasListener($handler);

    /**
     * 移除监听
     * @param string $handler 事件类型，类名
     */
    public function removeListener($handler);

    /**
     * 获取监听列表
     * @return array
     */
    public function getListeners();
}
