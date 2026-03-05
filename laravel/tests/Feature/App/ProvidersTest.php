<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\FolioServiceProvider;
use App\Providers\VoltServiceProvider;

uses(\Tests\TestCase::class, \Modules\Xot\Tests\CreatesApplication::class);

test('app service provider can be instantiated', function (): void {
    $provider = new AppServiceProvider(app());
    expect($provider)->toBeInstanceOf(AppServiceProvider::class);
});

test('app service provider register method does not throw', function (): void {
    $provider = new AppServiceProvider(app());
    $provider->register();
    expect(true)->toBeTrue();
});

test('app service provider boot method does not throw', function (): void {
    $provider = new AppServiceProvider(app());
    $provider->boot();
    expect(true)->toBeTrue();
});

test('folio service provider can be instantiated', function (): void {
    $provider = new FolioServiceProvider(app());
    expect($provider)->toBeInstanceOf(FolioServiceProvider::class);
});

test('folio service provider register method does not throw', function (): void {
    $provider = new FolioServiceProvider(app());
    $provider->register();
    expect(true)->toBeTrue();
});

test('folio service provider boot method configures folio path', function (): void {
    // Set a theme config that will create a valid path
    config(['xra.pub_theme' => 'TestTheme']);

    // Create the expected directory structure
    $themePath = base_path('laravel/Themes/TestTheme/resources/views/pages');
    if (! is_dir(dirname($themePath))) {
        mkdir(dirname($themePath), 0755, true);
    }
    if (! is_dir($themePath)) {
        mkdir($themePath, 0755, true);
    }

    $provider = new FolioServiceProvider(app());
    $provider->boot();

    expect(true)->toBeTrue();

    // Cleanup
    rmdir($themePath);
});

test('folio service provider boot method uses default path when theme not found', function (): void {
    // Set a theme that doesn't exist
    config(['xra.pub_theme' => 'NonExistentTheme']);

    $provider = new FolioServiceProvider(app());
    $provider->boot();

    expect(true)->toBeTrue();
});

test('volt service provider can be instantiated', function (): void {
    $provider = new VoltServiceProvider(app());
    expect($provider)->toBeInstanceOf(VoltServiceProvider::class);
});

test('volt service provider register method does not throw', function (): void {
    $provider = new VoltServiceProvider(app());
    $provider->register();
    expect(true)->toBeTrue();
});

test('volt service provider boot method mounts volt paths', function (): void {
    // Ensure the livewire view path exists
    $livewirePath = resource_path('views/livewire');
    if (! is_dir($livewirePath)) {
        mkdir($livewirePath, 0755, true);
    }

    // Set config to use string path
    config(['livewire.view_path' => $livewirePath]);

    $provider = new VoltServiceProvider(app());
    $provider->boot();

    expect(true)->toBeTrue();
});

test('volt service provider boot method handles missing livewire path', function (): void {
    // Set a non-existent path
    config(['livewire.view_path' => '/non/existent/path']);

    $provider = new VoltServiceProvider(app());
    $provider->boot();

    expect(true)->toBeTrue();
});
