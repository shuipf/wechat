<?php
// +----------------------------------------------------------------------
// | TemplateInterface 模板消息接口
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\template;

interface TemplateInterface
{
    /**
     * 获取模板 ID
     * @return string
     */
    public function getId();

    /**
     * 设置模板消息跳转链接
     * @param string $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * 获取模板消息跳转链接
     * @return string
     */
    public function getUrl();

    /**
     * 设置接收用户Openid
     * @param string $openid
     * @return $this
     */
    public function setOpenid($openid);

    /**
     * 获取接收用户Openid
     * @return string
     */
    public function getOpenid();

    /**
     * 添加模板参数
     * @param string $key 参数名
     * @param string $value 内容
     * @param string|null $color 颜色
     * @return $this
     */
    public function add($key, $value, $color = null);

    /**
     * 移除模板参数
     * @param string $key 参数名
     * @return $this
     */
    public function remove($key);

    /**
     * 获取请求内容
     * @return array
     */
    public function getRequestBody();
}
