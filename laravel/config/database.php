<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
            'transaction_mode' => 'DEFERRED',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        
        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
         
        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

        'user' => [
            'driver' => env('USER_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('USER_DB_URL'),
            'host' => env('USER_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('USER_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('USER_DB_DATABASE', env('DB_DATABASE', 'laravel_user')),
            'username' => env('USER_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('USER_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'job' => [
            'driver' => env('JOB_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('JOB_DB_URL'),
            'host' => env('JOB_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('JOB_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('JOB_DB_DATABASE', env('DB_DATABASE', 'laravel_job')),
            'username' => env('JOB_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('JOB_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'notify' => [
            'driver' => env('NOTIFY_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('NOTIFY_DB_URL'),
            'host' => env('NOTIFY_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('NOTIFY_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('NOTIFY_DB_DATABASE', env('DB_DATABASE', 'laravel_notify')),
            'username' => env('NOTIFY_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('NOTIFY_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'geo' => [
            'driver' => env('GEO_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('GEO_DB_URL'),
            'host' => env('GEO_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('GEO_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('GEO_DB_DATABASE', env('DB_DATABASE', 'laravel_geo')),
            'username' => env('GEO_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('GEO_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'media' => [
            'driver' => env('MEDIA_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('MEDIA_DB_URL'),
            'host' => env('MEDIA_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('MEDIA_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('MEDIA_DB_DATABASE', env('DB_DATABASE', 'laravel_media')),
            'username' => env('MEDIA_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('MEDIA_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'xot' => [
            'driver' => env('XOT_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('XOT_DB_URL'),
            'host' => env('XOT_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('XOT_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('XOT_DB_DATABASE', env('DB_DATABASE', 'laravel_xot')),
            'username' => env('XOT_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('XOT_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'activity' => [
            'driver' => env('ACTIVITY_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('ACTIVITY_DB_URL'),
            'host' => env('ACTIVITY_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('ACTIVITY_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('ACTIVITY_DB_DATABASE', env('DB_DATABASE', 'laravel_activity')),
            'username' => env('ACTIVITY_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('ACTIVITY_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'cms' => [
            'driver' => env('CMS_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('CMS_DB_URL'),
            'host' => env('CMS_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('CMS_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('CMS_DB_DATABASE', env('DB_DATABASE', 'laravel_cms')),
            'username' => env('CMS_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('CMS_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'gdpr' => [
            'driver' => env('GDPR_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('GDPR_DB_URL'),
            'host' => env('GDPR_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('GDPR_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('GDPR_DB_DATABASE', env('DB_DATABASE', 'laravel_gdpr')),
            'username' => env('GDPR_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('GDPR_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'lang' => [
            'driver' => env('LANG_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('LANG_DB_URL'),
            'host' => env('LANG_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('LANG_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('LANG_DB_DATABASE', env('DB_DATABASE', 'laravel_lang')),
            'username' => env('LANG_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('LANG_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'meetup' => [
            'driver' => env('MEETUP_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('MEETUP_DB_URL'),
            'host' => env('MEETUP_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('MEETUP_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('MEETUP_DB_DATABASE', env('DB_DATABASE', 'laravel_meetup')),
            'username' => env('MEETUP_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('MEETUP_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'seo' => [
            'driver' => env('SEO_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('SEO_DB_URL'),
            'host' => env('SEO_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('SEO_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('SEO_DB_DATABASE', env('DB_DATABASE', 'laravel_seo')),
            'username' => env('SEO_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('SEO_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'tenant' => [
            'driver' => env('TENANT_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
            'url' => env('TENANT_DB_URL'),
            'host' => env('TENANT_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('TENANT_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('TENANT_DB_DATABASE', env('DB_DATABASE', 'laravel_tenant')),
            'username' => env('TENANT_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('TENANT_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-database-'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

    ],

];
