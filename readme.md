# Laravel Plus API

Convenient Laravel API response tools and automated error handling functionality are provided.

## Requirement

- PHP ^7.4|^8.0
- Laravel >= 7

## Installation

### 1. Composer install
Run the Composer require command from the Terminal:
```bash
composer require hankz/laravel-plus-api
```
### 2. Setup
This package supports Laravel's auto-discovery feature and it's ready to use once installed.

### 3. Publishing the config file
You need publish the config file.
```bash
php artisan vendor:publish --provider="Hankz\LaravelPlusApi\LaravelPlusApiServiceProvider
```

### 4. Set Middleware
Set middleware for routes where you intend to utilize API responses.

 in `app/Http/Kernel.php`
```php
'api' => [
    //...

    \Hankz\LaravelPlusApi\Middleware\SetHeaderAcceptJson::class,
]
```

Set the priority of the middleware.

in `app/Http/Kernel.php`
```php
protected $middlewarePriority = [
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Hankz\LaravelPlusApi\Middleware\SetHeaderAcceptJson::class,
    \Hankz\LaravelPlusApi\Exceptions\ApiException::class,
    \App\Http\Middleware\Authenticate::class,
    \Illuminate\Routing\Middleware\ThrottleRequests::class,
    \Illuminate\Session\Middleware\AuthenticateSession::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    \Illuminate\Auth\Middleware\Authorize::class,
];
```

### 5. Exception Handler
Override exception Handler.

in `app/Exceptions/Handler.php`，加入：
```php
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Hankz\LaravelPlusApi\Classes\ApiResponseBuilder;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    //...

    protected function invalidJson($request, ValidationException $exception)
    {
        return ApiResponseBuilder::validationError($exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->error(config('plus-api.default_response.error.http_code'), Response::HTTP_UNAUTHORIZED);
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return $this->exceptionError(
            $this->convertExceptionToArray($e),
            config('plus-api.default_response.error.http_code'),
            $this->isHttpException($e) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR,
            $e->getMessage()
            $this->isHttpException($e) ? $e->getHeaders() : []
        );
    }
```
