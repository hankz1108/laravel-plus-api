<?php

namespace Hankz\LaravelPlusApi\Traits;

use Hankz\LaravelPlusApi\Classes\ApiResponseBuilder;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Return success response.
     *
     * @param object|array|null $data     array of primitives and supported objects to be returned in 'data' node
     *                                    of the JSON response, single supported object or @null if there's no
     *                                    to be returned
     * @param string|int|null   $apiCode  API code to be returned or @null to use value of config('plus-api.default_response.success.api_code')
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
        return ApiResponseBuilder::asSuccess($apiCode)
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
     * @param string      $apiCode  your API code to be returned with the response object
     * @param string|null $message  error message
     * @param int|null    $httpCode HTTP code to be used for HttpResponse sent or @null
     *                              for default DEFAULT_HTTP_CODE_ERROR
     * @param int|null    $headers  Http Header
     */
    public static function error(
        string $apiCode,
        string $message = null,
        int $httpCode = null,
        array $headers = null
    ): JsonResponse {
        return ApiResponseBuilder::asError($apiCode)
            ->withMessage($message)
            ->withHttpCode($httpCode)
            ->withHttpHeaders($headers)
            ->build();
    }
}
