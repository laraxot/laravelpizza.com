<?php

declare(strict_types=1);

$mysql_def = [
    'driver' => 'mysql',
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '3306'),
    'database' => 'mensa',
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
    'strict' => false,
    'engine' => null,
    'options' => [
        PDO::ATTR_EMULATE_PREPARES => true,
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ],
];

// connection name => database
$dbs = [
    'badge' => 'badge',
    'conto_annuale' => 'conto_annuale',
    'prenotazioni' => 'appuntamenti',
    'trasferte_dip' => 'trasferte_dip',
    'trasferte_adm' => 'trasferte_adm',
    'progressione' => 'progressione_new',  // progressione normale e' il vecchio
    'performance' => 'performance', // 'produ40', //inizio da un db vuoto
    'indennita' => 'rischio',
    'liveuser_general' => 'liveuser_general',
    'generale' => 'ptv_sigma',
    'mensa' => 'mensa',
    'menu' => 'menu',
    'indennita_condizioni_lavoro' => 'indennita_condizioni_lavoro',
    'indennita_responsabilita' => 'indennita_responsabilita',
    'blog' => 'ptv_blog',
    'rating' => 'ptv_blog',
    'geo' => 'ptv_blog',
    'tag' => 'ptv_blog',
    'legge_104' => 'legge104',
    'mobilita_volontaria' => 'mobilita_volontaria',
    'user' => 'ptv_user',
    'incentivi' => 'ptv_incentivi',
    'ptv' => 'ptv_data',
];

$def1 = [];
$def1['connections'] = [];
$def1['connections']['mysql'] = [
    'driver' => 'mysql',
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
];

foreach ($dbs as $k => $v) {
    $mysql_def['database'] = $v; // $v = database
    $def1['connections'][$k] = $mysql_def; // $k = connection name
    if ('liveuser_general' == $k) {
        $def1['connections'][$k]['prefix'] = 'liveuser_';
    }
}

// echo '<pre>';print_r($def);echo '</pre>';
// ddd($def1);

return $def1;
