<?php
// +----------------------------------------------------------------------
// | XmlResponse
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\bridge;

use Symfony\Component\HttpFoundation\Response;

class XmlResponse extends Response
{
    /**
     * 构造方法
     * XmlResponse constructor.
     * @param array $options
     * @param array $headers
     * @param int $status
     */
    public function __construct(array $options, array $headers = [], $status = 200)
    {
        $content = Serializer::xmlEncode($options);
        $headers = array_replace($headers, ['Content-Type' => 'application/xml']);
        parent::__construct($content, $status, $headers);
    }
}
