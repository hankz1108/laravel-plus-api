<?php

namespace Hankz\LaravelPlusApi\Traits;

use Hankz\LaravelPlusApi\Classes\BaseApiResponseBuilder;
use Illuminate\Http\JsonResponse;

trait ApiResponsible
{
    /**
     * Return success response.
     *
     * @param object|array|null $data     array of primitives and supported objects to be returned in 'data' node
     *                                    of the JSON response, single supported object or @null if there's no
     *                                    to be returned
     * @param string|int|null   $apiCode  API code to be returned or @null to use value of config('laravel-plus-api.default_response.success.api_code')
     * @param int|null          $httpCode HTTP code to be used for HttpResponse sent or @null
     *                                    for default DEFAULT_HTTP_CODE_OK
     * @param array|null        $headers  Http Header
     */
    public static function success(
        $data = null,
        $apiCode = null,
        int $httpCode = null,
        string $message = null,
        array $headers = null
    ): JsonResponse {
        return BaseApiResponseBuilder::asSuccess($apiCode)
            ->withData($data)
            ->withHttpCode($httpCode)
            ->withMessage($message)
            ->withHttpHeaders($headers)
            ->build();
    }

    /**
     * Builds error Response object. Supports optional arguments passed to Lang::get() if associated error
     * message uses placeholders as well as return data payload.
     *
     * @param string            $apiCode  your API code to be returned with the response object
     * @param string|null       $message  error message
     * @param int|null          $httpCode HTTP code to be used for HttpResponse sent or @null
     *                                    for default DEFAULT_HTTP_CODE_ERROR
     * @param object|array|null $data     array of primitives and supported objects to be returned in 'data' node
     * @param int|null          $headers  Http Header
     */
    public static function error(
        string $apiCode = null,
        int $httpCode = null,
        string $message = null,
        $data = null,
        array $headers = null
    ): JsonResponse {
        return BaseApiResponseBuilder::asError($apiCode)
            ->withMessage($message)
            ->withHttpCode($httpCode)
            ->withData($data)
            ->withHttpHeaders($headers)
            ->build();
    }
}
