<?php

namespace shuipf\wechat\payment\jsapi;

class PayChoose extends ConfigGenerator
{
    /**
     * 分解配置.
     */
    public function resolveConfig()
    {
        return [
            'timestamp' => $this['timeStamp'],
            'nonceStr' => $this['nonceStr'],
            'package' => $this['package'],
            'signType' => $this['signType'],
            'paySign' => $this['paySign'],
        ];
    }
}
