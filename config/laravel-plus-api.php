<?php

use Illuminate\Http\Response;

return [
    /*
    |--------------------------------------------------------------------------
    | Specify the structure of the Response return
    | 指定 Response 回傳結構
    |--------------------------------------------------------------------------
    |   {
    |       "status": {
    |           "code": 0,
    |           "message": "Invalid authentication. Could not decode token."
    |       },
    |       "data": null
    |       "errors": [],
    |   }
    */
    'keys' => [
        'success' => 'success',
        'api_code' => 'status.code',
        'message' => 'status.message',
        'data' => 'data',
        'errors' => 'errors',
    ],

    /*
    |--------------------------------------------------------------------------
    | Show exception details
    | 發生錯誤時是否回傳詳細錯誤訊息
    |--------------------------------------------------------------------------
    */
    'show_debug_data' => config('app.debug', false),

    /*
    |--------------------------------------------------------------------------
    | Set default return messages for different scenarios
    | 設置不同狀況默認的回傳訊息
    |--------------------------------------------------------------------------
    */
    'default_response' => [
        'success' => [
            'api_code' => 200,
            'http_code' => Response::HTTP_OK,
            'message' => 'Success.',
        ],

        'error' => [
            'api_code' => 500,
            'http_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Unknown server error.',
        ],

        'unauthenticated' => [
            'api_code' => 401,
            'http_code' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Unauthenticated.',
        ],

        'validation_fail' => [
            'api_code' => 422,
        ],
    ],
];
