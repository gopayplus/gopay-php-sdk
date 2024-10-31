<?php

namespace GopayPlus\Gopay\Enums;

enum EntryType: string
{
    case WECHAT_CASH = 'WX_CASH';
    case ALIPAY_CASH = 'ALIPAY_CASH';
    case BANK_CARD = 'BANK_CARD';
}
