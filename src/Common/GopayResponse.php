<?php

namespace GopayPlus\Gopay\Common;

use GopayPlus\Gopay\Support\Signature;
use GopayPlus\Gopay\Exceptions\HttpException;
use GopayPlus\Gopay\Exceptions\GopayException;

class GopayResponse implements \ArrayAccess
{

    use Signature;

    private string $signature;

    private array $data;

    private string $msg;

    private string $code;

    private string $key;

    /**
     * @throws GopayException
     */
    public function __construct($response, string $key)
    {
        if (!is_array($response)) {
            $response = json_decode($response, true);
        }
        if ($response['code'] !== 0) {
            throw new GopayException($response['msg'], $response['code']);
        }
        $this->signature = $response['sign'];
        $this->msg       = $response['msg'];
        $this->code      = $response['code'];
        $this->data      = $response['data'];
        $this->key       = $key;

        $this->checkSign();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @throws \GopayPlus\Gopay\Exceptions\GopayException
     */
    private function checkSign(): void
    {
        if ($this->signature !== $this->sign($this->getData(), $this->key)) {
            throw new GopayException('签名错误');
        }
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    public function isSuccess(): bool
    {
        return $this->code === '0';
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }
}
