<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default API Middleware
    |--------------------------------------------------------------------------
    */

    'api' => [
        'throttle:api',
        \Illuminate\Http\Middleware\HandlePrecognitiveRequests::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Guest Middleware
    |--------------------------------------------------------------------------
    */

    'guest' => [
        \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class.':admin',
        \App\Http\Middleware\GuestView::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Middleware
    |--------------------------------------------------------------------------
    */

    'admin' => [
        \App\Http\Middleware\GuestView::class,
    ],

];