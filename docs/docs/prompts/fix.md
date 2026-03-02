aggiungere 

        'gdpr' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE_GDPR', 'laravel_gdpr'),
            'username' => env('DB_USERNAME_GDPR', env('DB_USERNAME', 'marco')),
            'password' => env('DB_PASSWORD_GDPR', env('DB_PASSWORD', 'marco')),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

a laravel/config/*/*/database.php  o a laravel/config/*/database.php
e' sbagliato e' un errore GRAVE ! devi capire il perche' aggiornare le tue rules e memories e cartelle docs e anche quelle degli altri agenti ai, questo errore non deve mai piu' accadere, poi correggi e controlla
poi git commit e git push