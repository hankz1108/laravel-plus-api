<?php

namespace Hankz\LaravelPlusApi\Exceptions;

use Exception;
use Hankz\LaravelPlusApi\Classes\ApiResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class ApiException extends Exception implements HttpExceptionInterface
{
    // return api code, override if needed
    public const API_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    // return http code, override if needed
    public const HTTP_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    // return message, override if needed
    public const API_MESSAGE = '';

    /**
     * message.
     *
     * @var string
     */
    protected $message;

    /**
     * data.
     *
     * @var object|array|null data
     */
    protected $data;

    public function __construct(string $message = null, $data = null)
    {
        parent::__construct($message);

        $this->message = $message ?? static::API_MESSAGE;

        $this->data = $data;
    }

    /**
     * Report the exception.
     */
    public function report(): bool
    {
        return true;
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return ApiResponseBuilder::exceptionError(
            $this,
            static::API_CODE,
            static::HTTP_CODE,
            $this->message,
            $this->data
        );
    }

    public function getStatusCode(): int
    {
        return static::HTTP_CODE;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
