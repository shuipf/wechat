<?php
// +----------------------------------------------------------------------
// | Serializer
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\bridge;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class Serializer
{
    /**
     * json 编码
     * @param string|array $data 需要编码的数据
     * @param array $context
     * @return bool|false|float|int|string
     */
    public static function jsonEncode($data, array $context = [])
    {
        $defaults = [
            'json_encode_options' => defined('JSON_UNESCAPED_UNICODE')
                ? JSON_UNESCAPED_UNICODE
                : 0,
        ];

        return (new JsonEncoder())->encode($data, 'json', array_replace($defaults, $context));
    }

    /**
     * json 解码
     * @param string $data json数据
     * @param array $context
     * @return mixed
     */
    public static function jsonDecode($data, array $context = [])
    {
        $defaults = [
            'json_decode_associative' => true,
            'json_decode_recursion_depth' => 512,
            'json_decode_options' => 0,
        ];

        return (new JsonEncoder())->decode($data, 'json', array_replace($defaults, $context));
    }

    /**
     * xml 编码
     * @param $data
     * @param array $context
     * @return bool|float|int|string
     */
    public static function xmlEncode($data, array $context = [])
    {
        $defaults = [
            'xml_root_node_name' => 'xml',
            'xml_format_output' => true,
            'xml_version' => '1.0',
            'xml_encoding' => 'utf-8',
            'xml_standalone' => false,
        ];

        return (new XmlEncoder())->encode($data, 'xml', array_replace($defaults, $context));
    }

    /**
     * xml 解码
     * @param $data
     * @param array $context
     * @return array|mixed|string
     */
    public static function xmlDecode($data, array $context = [])
    {
        return (new XmlEncoder())->decode($data, 'xml', $context);
    }

    /**
     * xml/json to array
     * @param $string
     * @return array
     */
    public static function parse($string)
    {
        if (static::isJSON($string)) {
            $result = static::jsonDecode($string);
        } elseif (static::isXML($string)) {
            $result = static::xmlDecode($string);
        } else {
            throw new \InvalidArgumentException(sprintf('Unable to parse: %s', (string) $string));
        }
        return (array) $result;
    }

    /**
     * 是否json数据
     * @param string $data
     * @return bool
     */
    public static function isJSON($data)
    {
        return null !== @json_decode($data);
    }

    /**
     * 是否xml数据
     * @param $data
     * @return bool
     */
    public static function isXML($data)
    {
        $xml = @simplexml_load_string($data);
        return $xml instanceof \SimpleXmlElement;
    }
}
