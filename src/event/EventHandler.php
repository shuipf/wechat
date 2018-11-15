<?php
// +----------------------------------------------------------------------
// | EventHandler 事件处理器
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event;

use shuipf\wechat\bridge\Serializer;
use Symfony\Component\HttpFoundation\Request;

class EventHandler implements EventHandlerInterface
{
    /**
     * 请求对象
     * @var Request
     */
    protected $request;

    /**
     * 构造函数
     * EventHandler constructor.
     * @param Request|null $request 请求对象
     */
    public function __construct(Request $request = null)
    {
        $request = $request ?: Request::createFromGlobals();
        $this->setRequest($request);
    }

    /**
     * 设置请求对象
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * 获取请求对象
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * 请求事件处理
     * @param EventListenerInterface $listener
     */
    public function handle(EventListenerInterface $listener)
    {
        //获取事件监听列表
        if (!$listener->getListeners()) {
            return;
        }
        //获取请求内容
        $content = $this->request->getContent();
        try {
            $options = Serializer::parse($content);
        } catch (\InvalidArgumentException $e) {
            $options = [];
        }
        //循环处理监听事件
        foreach ($listener->getListeners() as $namespace => $callable) {
            $event = new $namespace($options);
            //是否是该事件
            if ($event->isValid()) {
                //触发事件
                $ref = $listener->trigger($namespace, $event);
                //如果没有返回false，直到遍历全部
                if (false === $ref) {
                    break;
                }
            }
        }
    }
}
