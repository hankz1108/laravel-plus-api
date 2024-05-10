## Installation

### 1. Composer install

Run the Composer require command from the Terminal:

```bash
composer require hankz/laravel-plus-api
```

> [!TIP]
> After Laravel 11, you may need to use `php artisan install:api` first to utilize the API.

### 2. Setup

This package supports Laravel's auto-discovery feature and it's ready to use once installed.

### 3. Publishing the config file

You need publish the config file.

```bash
php artisan vendor:publish --provider="Hankz\LaravelPlusApi\LaravelPlusApiServiceProvider"
```

### 4. Set Middleware

Set middleware for routes where you intend to utilize API responses.

in `bootstrap/app.php`

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(append:[
        \Hankz\LaravelPlusApi\Middleware\SetHeaderAcceptJson::class,
    ]);

    $middleware->priority([
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Hankz\LaravelPlusApi\Middleware\SetHeaderAcceptJson::class,
        \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Routing\Middleware\ThrottleRequestsWithRedis::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ]);
})
```

### 5. Exception Handler

Set exception Handler.

in `bootstrap/app.php`，add：

```php
use Hankz\LaravelPlusApi\Classes\ApiResponseBuilder;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

// other code...

->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (Throwable $throwable, Request $request) {

        if ($request->is('api/*')) { // When your API route prefix is not "api", remember to modify it.

            if ($throwable instanceof ValidationException) {
                return ApiResponseBuilder::validationError($throwable);
            }

            if ($throwable instanceof AuthenticationException) {
                return ApiResponseBuilder::error(
                    config('laravel-plus-api.default_response.unauthenticated.api_code'),
                    config('laravel-plus-api.default_response.unauthenticated.http_code'),
                    config('laravel-plus-api.default_response.unauthenticated.message')
                );
            }

            $defaultResponseConfig = config('laravel-plus-api.default_response.error');

            return ApiResponseBuilder::exceptionError(
                $throwable,
                data_get($defaultResponseConfig, 'api_code'),
                ($throwable instanceof HttpExceptionInterface) ? $throwable->getStatusCode() : data_get($defaultResponseConfig, 'http_code'),
                $throwable->getMessage() ? $throwable->getMessage() : data_get($defaultResponseConfig, 'message'),
                null,
                ($throwable instanceof HttpExceptionInterface) ? $throwable->getHeaders() : []
            );
        }
    });
})
```
