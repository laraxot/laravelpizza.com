<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Webmozart\Assert\Assert;

use function Safe\realpath as safe_realpath;
use UnexpectedValueException;

use function Safe\realpath;

// @phpstan-ignore-next-line trait.unused (used by Pest test case)
trait CreatesApplication
{
    public function createApplication(): Application
    {
        $basePath = safe_realpath(__DIR__."/../../../");

        $_ENV["APP_BASE_PATH"] = $basePath;

        $app = require $basePath."/bootstrap/app.php";

        if (! $app instanceof Application) {
            throw new UnexpectedValueException("Laravel bootstrap did not return an application.");
        }

        $app->instance("path.base", $basePath);
        $app->bind("path.public", fn () => $basePath."/public_html");
        $app->bind("path.storage", fn () => $basePath."/storage");

        /** @var Kernel $kernel */
        $kernel = $app->make(Kernel::class);
        $kernel->bootstrap();
        $app->boot();

        return $app;
    }
}
