<?php

declare(strict_types=1);

namespace GopayPlus\Gopay\Support;

class Config
{


    public function __construct(private string $baseURL, private string $mchNo, private string $appId, private string $key)
    {

    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getBaseURL(): string
    {
        return $this->baseURL;
    }

    public function getMchNo(): string
    {
        return $this->mchNo;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function getAttribute(): array
    {
        return [
            'key' => $this->key,
            'baseURL' => $this->baseURL,
            'mchNo' => $this->mchNo,
            'appId' => $this->appId,
        ];
    }
}
