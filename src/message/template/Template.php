<?php
// +----------------------------------------------------------------------
// | Template 模板消息
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\template;

class Template implements TemplateInterface
{
    /**
     * 模板 ID
     * @var string
     */
    protected $id;

    /**
     * 模板消息跳转链接
     * @var string
     */
    protected $url;

    /**
     * 接收用户 Openid
     * @var string
     */
    protected $openid;

    /**
     * 模板参数
     * @var array
     */
    protected $options;

    /**
     * 构造方法
     * Template constructor.
     * @param string $id 模板 ID
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * 获取模板 ID
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 设置模板消息跳转链接
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * 获取模板消息跳转链接
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 设置接收用户Openid
     * @param string $openid
     * @return $this
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
        return $this;
    }

    /**
     * 获取接收用户Openid
     * @return string
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * 添加模板参数
     * @param string $key 参数名
     * @param string $value 内容
     * @param string|null $color 颜色
     * @return $this
     */
    public function add($key, $value, $color = null)
    {
        $array = ['value' => $value];
        if (null !== $color) {
            $array['color'] = $color;
        }
        $this->options[$key] = $array;
        return $this;
    }

    /**
     * 移除模板参数
     * @param string $key 参数名
     * @return $this
     */
    public function remove($key)
    {
        if (isset($this->options[$key])) {
            unset($this->options[$key]);
        }
        return $this;
    }

    /**
     * 获取请求内容
     * @return array
     */
    public function getRequestBody()
    {
        return [
            'template_id' => $this->id,
            'touser' => $this->openid,
            'url' => $this->url,
            'data' => $this->options,
        ];
    }
}
