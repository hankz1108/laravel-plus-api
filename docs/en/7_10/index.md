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
php artisan vendor:publish --provider="Hankz\LaravelPlusApi\LaravelPlusApiServiceProvider"
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
    \App\Http\Middleware\Authenticate::class,
    \Illuminate\Routing\Middleware\ThrottleRequests::class,
    \Illuminate\Session\Middleware\AuthenticateSession::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    \Illuminate\Auth\Middleware\Authorize::class,
];
```

### 5. Exception Handler

Override exception Handler.

in `app/Exceptions/Handler.php`，add：

```php
use Hankz\LaravelPlusApi\Classes\ApiResponseBuilder;

class Handler extends ExceptionHandler
{
    //...

    protected function invalidJson($request, ValidationException $exception)
    {
        return ApiResponseBuilder::validationError($exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return ApiResponseBuilder::error(
            config('laravel-plus-api.default_response.unauthenticated.api_code'),
            config('laravel-plus-api.default_response.unauthenticated.http_code'),
            config('laravel-plus-api.default_response.unauthenticated.message')
        );
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return ApiResponseBuilder::exceptionError(
            $throwable,
            data_get($defaultResponseConfig, 'api_code'),
            ($throwable instanceof HttpExceptionInterface) ? $throwable->getStatusCode() : data_get($defaultResponseConfig, 'http_code'),
            $throwable->getMessage() ? $throwable->getMessage() : data_get($defaultResponseConfig, 'message'),
            null,
            ($throwable instanceof HttpExceptionInterface) ? $throwable->getHeaders() : []
        );
    }
```
