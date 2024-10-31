<?php

namespace GopayPlus\Gopay\Support;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GopayPlus\Gopay\Exceptions\HttpException;
use GopayPlus\Gopay\Exceptions\GopayException;
use GopayPlus\Gopay\Common\GopayResponse;

class HttpClient
{

    use Signature;

    protected const COMMON_PREFIX = "/api";

    private Config $config;

    private array $headers = [];

    private string $baseURL = '';

    private array $fixedParams = [
        'signType' => 'MD5',
        'version'  => '1.0',
    ];

    public function __construct(Config $config)
    {
        $this->config  = $config;
        $this->baseURL = $config->getBaseURL();
    }

    /**
     * @throws HttpException
     * @throws GuzzleException
     * @throws GopayException
     */
    public function getContent($url, $params): GopayResponse
    {
        $data = array_merge($params, $this->fixedParams, $this->addRequiredParams());

        return $this->sendRequest('GET', $url, $data);
    }

    /**
     * @throws HttpException
     * @throws GuzzleException
     * @throws GopayException
     */
    public function postForm($url, $data): GopayResponse
    {
        return $this->sendRequest('POST', $url, array_merge($data, $this->fixedParams, $this->addRequiredParams()));
    }

    private function buildURL($url, $params = [])
    {
        if (count($params) > 0) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * @throws HttpException
     * @throws GuzzleException
     */
    private function sendRequest(string $method, $url, $data = []): GopayResponse
    {
        $client = new Client([
            'base_uri' => $this->baseURL,
        ]);
        $data   = array_merge($data, ['sign' => $this->sign($data, $this->config->getKey())]);
        if ($method === 'GET') {
            $url = $this->buildURL($url, $data);
        }
        $response = $client->request($method, $url, [
            'headers'     => $this->headers,
            'form_params' => $method == 'POST' ? $data : [],
        ]);
        if ($response->getStatusCode() != 200) {
            throw new HttpException("Request failed with status code " . $response->getStatusCode());
        }

        return new GopayResponse($response->getBody()->getContents(), $this->config->getKey());
    }

    private function addRequiredParams(): array
    {
        return [
            'mchNo'   => $this->config->getMchNo(),
            'appId'   => $this->config->getAppId(),
            'reqTime' => Carbon::now()->getTimestampMs(),
        ];
    }

}
