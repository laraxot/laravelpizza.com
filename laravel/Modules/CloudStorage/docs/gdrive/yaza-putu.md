Laravel Google Drive Storage, You can store file like S3 AWS in laravel , this package allow to store file to google drive
star: 118
5 months ago
https://github.com/yaza-putu/laravel-google-drive-storage

~~~bash
composer require yaza/laravel-google-drive-storage
~~~

.env
~~~env
FILESYSTEM_CLOUD=google
GOOGLE_DRIVE_CLIENT_ID=xxx.apps.googleusercontent.com
GOOGLE_DRIVE_CLIENT_SECRET=xxx
GOOGLE_DRIVE_REFRESH_TOKEN=xxx
GOOGLE_DRIVE_FOLDER=
~~~

config filesystem.php
~~~php
'disks' => [
    'google' => [
      'driver' => 'google',
      'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
      'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
      'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
      'folder' => env('GOOGLE_DRIVE_FOLDER'),
    ]
]
~~~

example.php
~~~php
 Storage::disk('google')->put($filename, File::get($filepath));
~~~

-------------------------------------------------------------------------------------------------------