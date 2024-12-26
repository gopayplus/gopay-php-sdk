<?php

namespace GopayPlus\Gopay\Request;

use GopayPlus\Gopay\Support\HttpClient;

final class Unified extends HttpClient
{
    /**
     * @param string $url
     * @param array $params
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \GopayPlus\Gopay\Exceptions\HttpException
     * @throws \GopayPlus\Gopay\Exceptions\GopayException
     * @return array
     */
    public function get(string $url, ?array $params): array
    {
		if(empty($params)){
			$params = [];
		}
        return $this->getContent($url, $params)->toArray();
    }
	
	/**
	 * @param string $url
	 * @param array $params
	 *
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \GopayPlus\Gopay\Exceptions\HttpException
	 * @throws \GopayPlus\Gopay\Exceptions\GopayException
	 * @return array
	 */
	public function post(string $url, ?array $params): array
	{
		if (is_null($params)) {
			throw new \InvalidArgumentException('url and params are required');
		}
		
		return $this->postForm($url, $params)->toArray();
	}
}