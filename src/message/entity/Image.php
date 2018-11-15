<?php
// +----------------------------------------------------------------------
// | Image 图片消息
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\entity;

use shuipf\wechat\message\Entity;

class Image extends Entity
{
    /**
     * 通过上传多媒体文件，得到的id
     * @var int|string
     */
    protected $mediaId;

    /**
     * 设置通过上传多媒体文件，得到的id
     * @param int|string $mediaId
     * @return $this
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
        return $this;
    }

    /**
     * 消息内容
     * @return array|mixed
     */
    public function getBody()
    {
        $body = ['MediaId' => $this->mediaId];
        return ['Image' => $body];
    }

    /**
     * 消息类型
     * @return string
     */
    public function getType()
    {
        return 'image';
    }
}
