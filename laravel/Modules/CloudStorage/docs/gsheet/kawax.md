https://github.com/kawax/laravel-google-sheets
star: 408
2 months ago

~~~bash
composer require revolution/laravel-google-sheets
~~~

 config/google.php
~~~php
 // OAuth
 'client_id'        => env('GOOGLE_CLIENT_ID', ''),
 'client_secret'    => env('GOOGLE_CLIENT_SECRET', ''),
 'redirect_uri'     => env('GOOGLE_REDIRECT', ''),
 'scopes'           => [\Google\Service\Sheets::DRIVE, \Google\Service\Sheets::SPREADSHEETS],
 'access_type'      => 'online',
 'approval_prompt'  => 'auto',
 'prompt'           => 'consent', //"none", "consent", "select_account" default:none

 // or Service Account
 'file'    => storage_path('credentials.json'),
 'enable'  => env('GOOGLE_SERVICE_ENABLED', true),
 ~~~


.env
~~~bash
 GOOGLE_APPLICATION_NAME=
 GOOGLE_CLIENT_ID=
 GOOGLE_CLIENT_SECRET=
 GOOGLE_REDIRECT=
 GOOGLE_DEVELOPER_KEY=
 GOOGLE_SERVICE_ENABLED=
 GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION=
~~~

