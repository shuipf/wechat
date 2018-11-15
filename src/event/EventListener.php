<?php
// +----------------------------------------------------------------------
// | EventListener 监听器
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event;

class EventListener implements EventListenerInterface
{
    /**
     * 监听列表
     * @var array
     */
    protected $listeners = [];

    /**
     * 触发事件
     * @param $handler
     * @param Event $event
     * @return mixed
     */
    public function trigger($handler, Event $event)
    {
        if ($listener = $this->getListener($handler)) {
            return call_user_func_array($listener, [$event]);
        }
    }

    /**
     * 添加监听
     * @param $handler
     * @param callable $callable
     * @return $this
     */
    public function addListener($handler, callable $callable)
    {
        if (!class_exists($handler)) {
            throw new \InvalidArgumentException(sprintf('Invlaid Handler "%s"', $handler));
        }
        if (!is_subclass_of($handler, Event::class)) {
            throw new \InvalidArgumentException(sprintf(
                'The Handler "%s" must be extends "%s"', $handler, Event::class));
        }
        $this->listeners[$handler] = $callable;
        return $this;
    }

    /**
     * 获取指定监听事件
     * @param $handler
     * @return mixed
     */
    public function getListener($handler)
    {
        if ($this->hasListener($handler)) {
            return $this->listeners[$handler];
        }
    }

    /**
     * 判断该监听事件是否存在
     * @param $handler
     * @return bool
     */
    public function hasListener($handler)
    {
        return array_key_exists($handler, $this->listeners);
    }

    /**
     * 移除监听
     * @param $handler
     */
    public function removeListener($handler)
    {
        if ($this->hasListener($handler)) {
            unset($this->listeners[$handler]);
        }
    }

    /**
     * 获取监听列表
     * @return array
     */
    public function getListeners()
    {
        return $this->listeners;
    }
}
