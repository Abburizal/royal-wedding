<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Provider
    |--------------------------------------------------------------------------
    | Supported: "fonnte", "wablas"
    */
    'provider' => env('WHATSAPP_PROVIDER', 'fonnte'),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    | Fonnte:  https://app.fonnte.com → Dashboard → Token
    | Wablas:  https://my.wablas.com → API Token
    */
    'api_key' => env('WHATSAPP_API_KEY', ''),
];
