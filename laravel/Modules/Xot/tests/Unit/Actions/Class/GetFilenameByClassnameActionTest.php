<?php

declare(strict_types=1);

use Modules\Xot\Actions\Class\GetFilenameByClassnameAction;
use Tests\TestCase;

uses(TestCase::class);

it('returns the source filename for an existing class', function (): void {
    $action = app(GetFilenameByClassnameAction::class);

    $path = $action->execute(GetFilenameByClassnameAction::class);

    expect($path)->toBe(base_path('Modules/Xot/app/Actions/Class/GetFilenameByClassnameAction.php'));
});

it('throws when class does not exist and no reflection error is raised', function (): void {
    $action = app(GetFilenameByClassnameAction::class);

    $action->execute('Modules\\Xot\\NonExisting\\DefinitelyMissingClass');
})->throws(Exception::class);

it('returns fallback path when autoload raises an exception', function (): void {
    $action = app(GetFilenameByClassnameAction::class);

    $autoload = static function (string $class): void {
        if ('Broken\\ClassName' === $class) {
            throw new Exception('autoload failure');
        }
    };

    spl_autoload_register($autoload);

    try {
        $path = $action->execute('Broken\\ClassName');

        expect($path)->toBe(base_path('Broken/ClassName.php'));
    } finally {
        spl_autoload_unregister($autoload);
    }
});
