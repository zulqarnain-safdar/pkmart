<?php

return [
    /*
    |--------------------------------------------------------------------------
    | EasyPaisa Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for EasyPaisa payment gateway integration
    |
    */

    'user_id' => env('EASYPAISA_USER_ID'),
    'password' => env('EASYPAISA_PASSWORD'),
    'store_id' => env('EASYPAISA_STORE_ID'),
    'currency_code' => env('EASYPAISA_CURRENCY_CODE', 'PKR'),
    'language' => env('EASYPAISA_LANGUAGE', 'EN'),
    'api_version' => env('EASYPAISA_API_VERSION', '1.0'),
    
    // URLs
    'sandbox_url' => env('EASYPAISA_SANDBOX_URL', 'https://sandbox-developer.easypaisa.com.pk/'),
    'production_url' => env('EASYPAISA_PRODUCTION_URL', 'https://developer.easypaisa.com.pk/'),
    'return_url' => env('EASYPAISA_RETURN_URL', env('APP_URL') . '/api/payments/easypaisa/return'),
    'notify_url' => env('EASYPAISA_NOTIFY_URL', env('APP_URL') . '/api/payments/easypaisa/notify'),
    
    // Environment
    'environment' => env('EASYPAISA_ENVIRONMENT', 'sandbox'), // sandbox or production
    
    // Additional settings
    'expiry_hours' => env('EASYPAISA_EXPIRY_HOURS', 24),
    'auto_redirect' => env('EASYPAISA_AUTO_REDIRECT', true),
    
    // RSA Keys for encryption
    'private_key' => env('EASYPAISA_PRIVATE_KEY'),
    'public_key' => env('EASYPAISA_PUBLIC_KEY'),
];
