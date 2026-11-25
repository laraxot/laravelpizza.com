<?php

declare(strict_types=1);
use Modules\Xot\Helpers\PathHelper;
use Modules\Xot\Tests\XotBaseTestCase;

uses(XotBaseTestCase::class);

it('constructs the module path', function (): void {
    $basePath = PathHelper::$modulesBasePath;
    $moduleName = 'User';

    $result = PathHelper::modulePath($moduleName);

    expect($result)->toContain('User');
    expect($result)->toContain('Modules');
    expect($result)->toBe($basePath.'/User');
});

it('constructs the models path', function (): void {
    $result = PathHelper::modelsPath('User');

    expect($result)->toContain('User');
    expect($result)->toContain('Models');
    expect($result)->toEndWith('/Models');
});

it('constructs the migrations path', function (): void {
    $result = PathHelper::migrationsPath('User');

    expect($result)->toContain('database/migrations');
});

it('constructs the controllers path', function (): void {
    $result = PathHelper::controllersPath('User');

    expect($result)->toContain('Controllers');
    expect($result)->toContain('Http');
});

it('constructs the seeders path', function (): void {
    $result = PathHelper::seedersPath('Media');

    expect($result)->toContain('seeders');
});

it('constructs the providers path', function (): void {
    $result = PathHelper::providersPath('Xot');

    expect($result)->toContain('Providers');
});

it('constructs the views path', function (): void {
    $result = PathHelper::viewsPath('UI');

    expect($result)->toContain('views');
    expect($result)->toContain('resources');
});

it('constructs the filament resources path', function (): void {
    $result = PathHelper::filamentResourcesPath('Demo');

    expect($result)->toContain('Filament');
    expect($result)->toContain('Resources');
});

it('validates a path with proper format', function (): void {
    $validPath = '/var/www/html/project/laravel/Modules/User/app/Models';

    expect(PathHelper::isValidPath($validPath))->toBeTrue();
});

it('rejects a path missing the laravel segment', function (): void {
    $invalidPath = '/var/www/html/project/Modules/User/app/Models';

    expect(PathHelper::isValidPath($invalidPath))->toBeFalse();
});

it('validates a generic path', function (): void {
    expect(PathHelper::isValidPath('/var/www/generic/path'))->toBeTrue();
});

it('fixes a path with wrong prefix', function (): void {
    $wrongPath = '/var/www/html/Modules/User/Models';

    $corrected = PathHelper::correctPath($wrongPath);

    expect($corrected)->toContain(PathHelper::$modulesBasePath);
    expect($corrected)->not->toContain('/var/www/html/Modules/');
});

it('leaves a valid path unchanged', function (): void {
    $validPath = '/var/www/html/project/laravel/Modules/User';

    $corrected = PathHelper::correctPath($validPath);

    expect($corrected)->toBe($validPath);
});

it('rejects a missing module', function (): void {
    expect(PathHelper::moduleExists('__missing_module__'))->toBeFalse();
});

it('returns an empty array for a missing base path', function (): void {
    expect(PathHelper::getModules())->toBe([]);
});
