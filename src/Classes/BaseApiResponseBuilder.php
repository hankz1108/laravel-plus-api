<?php

namespace Hankz\LaravelPlusApi\Classes;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class BaseApiResponseBuilder
{
    /**
     * Is Success.
     *
     * @var bool
     */
    protected $success = false;

    /**
     * Api code.
     *
     * @var string
     */
    protected $api_code;

    /**
     * Http code.
     *
     * @var int
     */
    protected $httpCode;

    /**
     * Message.
     *
     * @var string
     */
    protected $message;

    /**
     * data response.
     *
     * @var array|null
     */
    protected $data;

    /**
     * errors.
     *
     * @var array|null
     */
    protected $errors;

    /**
     * Data for debug.
     *
     * @var array
     */
    protected $debugData = [];

    /**
     * Http headers.
     *
     * @var array
     */
    protected $httpHeaders = [];

    /**
     * Response.
     *
     * @var array
     */
    protected $response = [];

    /**
     * Private constructor. Use asSuccess() and asError() static methods to obtain instance of Builder.
     */
    public function __construct(bool $success = true, string $apiCode = null)
    {
        $this->success = $success;
        $this->api_code = $apiCode ?? (
            $success ? config('laravel-plus-api.default_response.success.api_code') : config('laravel-plus-api.default_response.error.api_code')
        );
    }

    public static function asSuccess(string $apiCode = null): self
    {
        return new self(true, $apiCode ?? config('laravel-plus-api.default_response.success.api_code'));
    }

    public static function asError(string $apiCode = null): self
    {
        return new self(false, $apiCode ?? config('laravel-plus-api.default_response.error.api_code'));
    }

    public function withHttpCode(int $httpCode = null): self
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    public function withHttpHeaders(array $httpHeaders = null): self
    {
        $this->httpHeaders = $httpHeaders ?? [];

        return $this;
    }

    public function withMessage(string $message = null): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param object|array|null $data
     */
    public function withData($data = null): self
    {
        $this->data = $data;

        return $this;
    }

    public function withDebugData(array $debugData = null): self
    {
        $this->debugData = $debugData;

        return $this;
    }

    public function withErrors(array $errors = null): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * api json response.
     */
    public function build(): JsonResponse
    {
        return $this->setResponseStructure()
            ->setResponseDebugData()
            ->make();
    }

    protected function setResponseStructure(): self
    {
        $keys = config('laravel-plus-api.keys');

        foreach ($keys as $key => $keyValue) {
            if (property_exists($this, $key)) {
                $keyValue = $keyValue ? $keyValue : $key;

                Arr::set($this->response, $keyValue, $this->{$key});

                // 如果成功不顯示errors
                if ('errors' == $key && empty($this->errors)) {
                    unset($this->response[$keyValue]);
                }
            }
        }

        return $this;
    }

    protected function setResponseDebugData(): self
    {
        if (config('laravel-plus-api.show_debug_data') && !empty($this->debugData)) {
            Arr::set($this->response, 'debug_data', $this->debugData);
        }

        return $this;
    }

    protected function make(): JsonResponse
    {
        return response()
            ->json(
                $this->response,
                $this->httpCode ?? $this->success ? config('laravel-plus-api.default_response.success.http_code') : config('laravel-plus-api.default_response.error.http_code'),
                $this->httpHeaders
            );
    }
}
