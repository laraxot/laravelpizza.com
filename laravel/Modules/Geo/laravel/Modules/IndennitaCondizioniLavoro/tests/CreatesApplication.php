<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use RuntimeException;

trait CreatesApplication
{
    public function createApplication(): Application
    {
        $basePath = realpath(__DIR__.'/../../../');
        if ($basePath === false) {
            throw new RuntimeException('Laravel base path non trovato.');
        }

        $_ENV['APP_BASE_PATH'] = $basePath;

        $app = require $basePath.'/bootstrap/app.php';
        if (! $app instanceof Application) {
            throw new RuntimeException('bootstrap/app.php non ha restituito Application.');
        }

        $app->instance('path.base', $basePath);
        $app->bind('path.public', fn (): string => $basePath.'/public_html');
        $app->bind('path.storage', fn (): string => $basePath.'/storage');

        $kernel = $app->make(Kernel::class);
        $kernel->bootstrap();
        $app->boot();

        return $app;
    }
}
