<?php

namespace GopayPlus\Gopay\Request;

use GopayPlus\Gopay\Common\GopayResponse;
use GopayPlus\Gopay\Enums\EntryType;
use GopayPlus\Gopay\Enums\IfCode;
use GopayPlus\Gopay\Support\HttpClient;

final class Transfer extends HttpClient
{
    const TRANSFER_PREFIX = self::COMMON_PREFIX . "/transfer";

    const TRANSFER_ORDER_URL = self::TRANSFER_PREFIX . 'Order';

    const QUERY_URL = self::TRANSFER_PREFIX . '/query';

    /**
     * @param \GopayPlus\Gopay\Enums\IfCode    $if_code
     * @param \GopayPlus\Gopay\Enums\EntryType $entry_type
     * @param int                              $amount
     * @param string                           $account_no
     * @param string|null                      $account_name
     * @param string|null                      $bank_name
     * @param string|null                      $client_ip
     * @param string|null                      $transfer_desc
     * @param string|null                      $notify_url
     * @param string|null                      $channel_extra
     * @param string|null                      $ext_param
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \GopayPlus\Gopay\Exceptions\HttpException
     * @throws \GopayPlus\Gopay\Exceptions\GopayException
     * @return array{
     *     accountNo: string,
     *     amount: int,
     *     channelOrderNo: string,
     *     mchOrderNo: string,
     *     state: int,
     *     transferId: string
     *  }
     */
    public function transferOrder(IfCode    $if_code,
                                  EntryType $entry_type,
                                  int       $amount,
                                  string    $account_no,
                                  ?string   $account_name = null,
                                  ?string   $bank_name = null,
                                  ?string   $client_ip = null,
                                  ?string   $transfer_desc = null,
                                  ?string   $notify_url = null,
                                  ?string   $channel_extra = null,
                                  ?string   $ext_param = null): array
    {
        $params = array_filter([
            'ifCode'       => $if_code->value,
            'entryType'    => $entry_type->value,
            'amount'       => $amount,
            'currency'     => 'cny',
            'accountNo'    => $account_no,
            'accountName'  => $account_name,
            'bankName'     => $bank_name,
            'clientIp'     => $client_ip,
            'transferDesc' => $transfer_desc,
            'notifyUrl'    => $notify_url,
            'channelExtra' => $channel_extra,
            'extParam'     => $ext_param,
        ], function ($value) {
            return !is_null($value);
        });

        return $this->postForm(self::TRANSFER_ORDER_URL, $params)->toArray();
    }

    /**
     * @param string|null $transfer_id
     * @param string|null $mch_order_no
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \GopayPlus\Gopay\Exceptions\HttpException
     * @throws \GopayPlus\Gopay\Exceptions\GopayException
     * @return array{
     *     accountName: string,
     *     accountNo: string,
     *     amount: int,
     *     appId: string,
     *     bankName: string,
     *     channelOrderNo: string,
     *     createdAt: int,
     *     currency: string,
     *     entryType: string,
     *     errCode: string,
     *     errMsg: string,
     *     extraParam: string,
     *     ifCode: string,
     *     mchNo: string,
     *     mchOrderNo: string,
     *     state: int,
     *     transferDesc: string,
     *     transferId: string,
     *     createdAt: int,
     *     successTime: int
     * }
     */
    public function query(?string $transfer_id, ?string $mch_order_no): array
    {
        if (is_null($transfer_id) && is_null($mch_order_no)) {
            throw new \InvalidArgumentException('one of transferId and mchOrderNo is required');
        }
        $params = [
            'transferId' => $transfer_id,
            'mchOrderNo' => $mch_order_no,
        ];

        return $this->postForm(self::QUERY_URL, $params)->toArray();
    }
}