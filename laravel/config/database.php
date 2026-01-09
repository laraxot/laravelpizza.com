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
        'user' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel_user'),
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
         /*
        'user' => [
            'driver' => env('USER_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('USER_DB_URL', env('DB_URL')),
            'host' => env('USER_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('USER_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('USER_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('USER_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('USER_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('USER_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('USER_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('USER_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('USER_DB_PREFIX', 'user_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        // Laraxot Multi-Database Architecture
        // Each module has its own connection for isolation and scalability

        'cms' => [
            'driver' => env('CMS_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('CMS_DB_URL', env('DB_URL')),
            'host' => env('CMS_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('CMS_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('CMS_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('CMS_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('CMS_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('CMS_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('CMS_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('CMS_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('CMS_DB_PREFIX', 'cms_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'geo' => [
            'driver' => env('GEO_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('GEO_DB_URL', env('DB_URL')),
            'host' => env('GEO_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('GEO_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('GEO_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('GEO_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('GEO_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('GEO_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('GEO_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('GEO_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('GEO_DB_PREFIX', 'geo_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'job' => [
            'driver' => env('JOB_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('JOB_DB_URL', env('DB_URL')),
            'host' => env('JOB_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('JOB_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('JOB_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('JOB_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('JOB_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('JOB_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('JOB_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('JOB_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('JOB_DB_PREFIX', 'job_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'lang' => [
            'driver' => env('LANG_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('LANG_DB_URL', env('DB_URL')),
            'host' => env('LANG_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('LANG_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('LANG_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('LANG_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('LANG_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('LANG_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('LANG_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('LANG_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('LANG_DB_PREFIX', 'lang_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'media' => [
            'driver' => env('MEDIA_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('MEDIA_DB_URL', env('DB_URL')),
            'host' => env('MEDIA_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('MEDIA_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('MEDIA_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('MEDIA_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('MEDIA_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('MEDIA_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('MEDIA_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('MEDIA_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('MEDIA_DB_PREFIX', 'media_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'notify' => [
            'driver' => env('NOTIFY_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('NOTIFY_DB_URL', env('DB_URL')),
            'host' => env('NOTIFY_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('NOTIFY_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('NOTIFY_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('NOTIFY_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('NOTIFY_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('NOTIFY_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('NOTIFY_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('NOTIFY_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('NOTIFY_DB_PREFIX', 'notify_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'tenant' => [
            'driver' => env('TENANT_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('TENANT_DB_URL', env('DB_URL')),
            'host' => env('TENANT_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('TENANT_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('TENANT_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('TENANT_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('TENANT_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('TENANT_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('TENANT_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('TENANT_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('TENANT_DB_PREFIX', 'tenant_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'xot' => [
            'driver' => env('XOT_DB_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'url' => env('XOT_DB_URL', env('DB_URL')),
            'host' => env('XOT_DB_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('XOT_DB_PORT', env('DB_PORT', '3306')),
            'database' => env('XOT_DB_DATABASE', env('DB_DATABASE', database_path('database.sqlite'))),
            'username' => env('XOT_DB_USERNAME', env('DB_USERNAME', 'root')),
            'password' => env('XOT_DB_PASSWORD', env('DB_PASSWORD', '')),
            'unix_socket' => env('XOT_DB_SOCKET', env('DB_SOCKET', '')),
            'charset' => env('XOT_DB_CHARSET', env('DB_CHARSET', 'utf8mb4')),
            'collation' => env('XOT_DB_COLLATION', env('DB_COLLATION', 'utf8mb4_unicode_ci')),
            'prefix' => env('XOT_DB_PREFIX', 'xot_'),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],
        */
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
