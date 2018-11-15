<?php
// +----------------------------------------------------------------------
// | Video 视频消息
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\entity;

use shuipf\wechat\message\Entity;

class Video extends Entity
{
    /**
     * 通过上传多媒体文件，得到的id
     * @var string|int
     */
    protected $mediaId;

    /**
     * 视频消息的标题
     * @var string
     */
    protected $title;

    /**
     * 视频消息的描述
     * @var string
     */
    protected $description;

    /**
     * 通过上传多媒体文件，得到的id
     * @param string|int $mediaId
     * @return $this
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
        return $this;
    }

    /**
     * 视频消息的标题
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * 视频消息的描述
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * 消息内容
     * @return array|mixed
     */
    public function getBody()
    {
        $body = [
            'MediaId' => $this->mediaId,
            'Title' => $this->title,
            'Description' => $this->description,
        ];

        return ['Video' => $body];
    }

    /**
     * 消息类型
     * @return string
     */
    public function getType()
    {
        return 'video';
    }
}
