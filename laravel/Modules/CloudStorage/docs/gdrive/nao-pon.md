Flysystem adapter for Google Drive
star: 350
4 years ago
https://github.com/nao-pon/flysystem-google-drive
tutorial 
https://medium.com/@dennissmink/laravel-backup-database-to-your-google-drive-f4728a2b74bd

~~~bash
composer require nao-pon/flysystem-google-drive
~~~

~~~php
$client = new \Google_Client();
$client->setClientId('[app client id].apps.googleusercontent.com');
$client->setClientSecret('[app client secret]');
$client->refreshToken('[your refresh token]');
~~~
how to extends storage  con screenshot di come creare 
https://robindirksen.com/blog/google-drive-storage-as-filesystem-in-laravel


-----------------------------------------------------------------------------------------------
-- DEMO --
star: 403
3 year ago
https://github.com/ivanvermeyen/laravel-google-drive-demo