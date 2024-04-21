<?php

return [
    /*
    |--------------------------------------------------------------------------
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
    |--------------------------------------------------------------------------
    |   發生錯誤時是否回傳詳細錯誤訊息
    */
    'show_debug_data' => config('app.debug', false),

    'default_response' => [
        'success' => [
            'api_code' => 0,
            'http_code' => 200,
            'message' => 'Success',
        ],

        'error' => [
            'api_code' => 1,
            'http_code' => 400,
            'message' => 'Unknown error',
        ],
    ]
];
