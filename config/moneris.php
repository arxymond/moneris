<?php

/*
|--------------------------------------------------------------------------
| Moneris Payment Provider configurations
|--------------------------------------------------------------------------
*/

return [

    'store_id'              => env('MONERIS_STORE_ID'), // each merchant have store_id assigned by Moneris
    'api_token'             => env('MONERIS_API_TOKEN'), // api_token provided by Moneris
    'country_code'          => env('MONERIS_COUNTRY_CODE'), // CA for canada or US for USA
    'dynamic_desc_prefix'   => env('MONERIS_DYNAMIC_DESC_PREFIX'), // Dynamic description which will be shown on customer's bank statement
    'test_mode'             => env('MONERIS_TEST_MODE'), // some kind of sandbox indicator for Moneris

];
