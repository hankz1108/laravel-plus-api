<?php

namespace Hankz\LaravelPlusApi\Exceptions;

use Exception;
use Hankz\LaravelPlusApi\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class ApiException extends Exception implements HttpExceptionInterface
{
    use ApiResponse;

    public const API_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    public const HTTP_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

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

        if (!is_null($message)) {
            $this->message = $message;
        }

        if (!is_null($data)) {
            $this->data = $data;
        }
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
        return $this->error(
            static::API_CODE,
            static::HTTP_CODE,
            $this->message,
            $this->data
        );
    }
}
