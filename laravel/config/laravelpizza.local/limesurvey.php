<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | URL of your LimeSurvey install
    |--------------------------------------------------------------------------
    |
    | This is the URL of the LimeSurvey install that you are connecting to.
    |
    | By default, RemoteControl is not enabled, follow instructions at
    | https://manual.limesurvey.org/RemoteControl_2_API to enable
    |
    */
    'url' => env('LIMESURVEY_URL', 'https://localhost/limesurvey/'),

    /*
    |--------------------------------------------------------------------------
    | Administrator Username to access the API With
    |--------------------------------------------------------------------------
    |
    | This can be any administrator account, but should probably be a generic
    | only used for this purpose
    |
    */
    'username' => env('LIMESURVEY_USERNAME', ''),

    /*
    |--------------------------------------------------------------------------
    | Password of the account being used
    |--------------------------------------------------------------------------
    */
    'password' => env('LIMESURVEY_PASSWORD', ''),
];
