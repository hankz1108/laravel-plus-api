<?php

namespace Hankz\LaravelPlusApi\Classes;

use Hankz\LaravelPlusApi\Traits\ApiResponsible;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

class ApiResponseBuilder
{
    use ApiResponsible;

    /**
     * return validation error response.
     */
    public static function validationError(ValidationException $e): JsonResponse
    {
        return BaseApiResponseBuilder::asError(config('laravel-plus-api.default_response.validation_fail.api_code'))
            ->withErrors($e->errors())
            ->withHttpCode($e->status)
            ->build();
    }

    /**
     * @param object|array|null $data
     */
    public static function exceptionError(
        Throwable $throwable = null,
        string $apiCode = null,
        int $httpCode,
        string $message = null,
        mixed $data = null,
        array $headers = []
    ): JsonResponse {
        $apiCode = $apiCode ?? config('laravel-plus-api.default_response.error.api_code');

        return BaseApiResponseBuilder::asError($apiCode)
            ->withDebugData(
                // copy by Laravel 11 Illuminate\Foundation\Exceptions\Handler::convertExceptionToArray()
                [
                    'message' => $throwable->getMessage(),
                    'exception' => get_class($throwable),
                    'file' => $throwable->getFile(),
                    'line' => $throwable->getLine(),
                    'trace' => collect($throwable->getTrace())->map(fn ($trace) => Arr::except($trace, ['args']))->all(),
                ],
            )
            ->withHttpCode($httpCode)
            ->withMessage($message)
            ->withData($data)
            ->withHttpHeaders($headers)
            ->build();
    }
}
