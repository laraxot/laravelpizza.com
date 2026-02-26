#Install from zero

~~~ bash
mkdir demo01
cd demo01
laravel new laravel (with breeze, volt+class, darkMode, Pest, no git)
mv laravel/public  public_html
~~~

edit public_html/index.php
~~~ php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));
define('LARAVEL_DIR', __DIR__.'/../laravel');


// Determine if the application is in maintenance mode...
if (file_exists($maintenance = LARAVEL_DIR.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require LARAVEL_DIR.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once LARAVEL_DIR.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
~~~

create new file laravel/app/Application.php
~~~ php
<?php
declare(strict_types=1);

namespace App;

class Application extends \Illuminate\Foundation\Application
{
    public function publicPath($path = ''): string
    {
        $tmp = $this->basePath.'/../public_html/'.$path;
        $tmp = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $tmp);
        if (realpath($tmp) === false) {
            return realpath($this->basePath.'/../public_html/').'/'.$path;
        }

        return realpath($tmp);
    }
}
~~~

edit file laravel/bootstrap/app.php
~~~ php
<?php

//use Illuminate\Foundation\Application;
use App\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
~~~

edit file composer.json 
~~~ json
{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": [
        "laravel",
        "framework"
    ],
    "license": "MIT",
    "require": {
        "php": "^8.2",
        "filament/filament": "^3.4",
        "laravel/framework": "^11.9",
        "filament/filament": "^3.3",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "^11.0"
    },
    "require-dev": {

    },
    "repositories_comment": [
        {
            "type": "path",
            "url": "./packages/savannabits/filament-modules"
        }
    ],
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Modules\\": "Modules/",
            "Themes\\": "Themes/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        },
        "files": [
            "Modules/Xot/Helpers/Helper.php"
        ]
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "@php artisan filament:upgrade"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi",
            "@php -r \"file_exists('database/database.sqlite') || touch('database/database.sqlite');\"",
            "@php artisan migrate --ansi"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        },
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ]
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true,
            "wikimedia/composer-merge-plugin": true,
            "dealerdirect/phpcodesniffer-composer-installer": true
        }
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}

~~~ 

from folder demo01
~~~ bash
git init
~~~

create Folders :
 laravel/Modules
 laravel/Themes

 inside folder laravel/modules

~~~ bash
 git submodule add https://github.com/laraxot/module_xot_fila3.git Xot
 git submodule add https://github.com/laraxot/module_tenant_fila3.git Tenant
 git submodule add https://github.com/laraxot/module_user_fila3.git User
 git submodule add https://github.com/laraxot/module_notify_fila3.git Notify
 git submodule add https://github.com/laraxot/module_ui_fila3.git UI
~~~


from folder laravel
~~~ bash
git submodule add  https://github.com/laraxot/filament-modules.git  packages/savannabits/filament-modules

composer update -W (--with-all-dependencies)
~~~ 


