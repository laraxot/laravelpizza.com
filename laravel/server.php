<?php

declare(strict_types=1);

// Router del server integrato: richiama quello del framework, quindi `php artisan serve` (che preferisce
// laravel/server.php se esiste) si comporta come prima: docroot = cwd = public_html.
// Serve a bashscripts/tools/visual/scratch-auth-fixture.sh (`php -S ... laravel/server.php`), che lo cerca qui.
// `return` e' essenziale: il router del framework restituisce false per i file statici, ed e' quel false a farli servire a `php -S`.
return require __DIR__.'/vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php';
