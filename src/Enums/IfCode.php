<?php

namespace GopayPlus\Gopay\Enums;

enum IfCode: string
{
    case WECHATPAY = 'wxpay';
    case ALIPAY = 'alipay';
}