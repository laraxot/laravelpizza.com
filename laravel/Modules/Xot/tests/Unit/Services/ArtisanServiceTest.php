<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Modules\Xot\Services\ArtisanService;

use function Safe\ob_end_clean;
use function Safe\ob_start;

test('artisan service act method returns empty string for unknown commands', function (): void {
    Request::shouldReceive('input')
        ->with('module', '')
        ->andReturn('');

    $result = ArtisanService::act('unknown-command');

    expect($result)->toBe('');
});

test('artisan service act method handles migrate command', function (): void {
    Request::shouldReceive('input')
        ->with('module', '')
        ->andReturn('');

    // Mock DB and Artisan facades
    DB::shouldReceive('purge')->once()->with('mysql');
    DB::shouldReceive('reconnect')->once()->with('mysql');
    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Migration completed');

    $result = ArtisanService::act('migrate');

    expect($result)->toContain('Migration completed');
});

test('artisan service act method handles module parameter', function (): void {
    Request::shouldReceive('input')
        ->with('module', '')
        ->andReturn('TestModule');

    DB::shouldReceive('purge')->once()->with('mysql');
    DB::shouldReceive('reconnect')->once()->with('mysql');
    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Module migration');

    ob_start();
    $result = ArtisanService::act('migrate');
    ob_end_clean();

    expect($result)->toContain('Module migration');
});

test('artisan service handles non-string module parameter', function (): void {
    Request::shouldReceive('input')
        ->with('module', '')
        ->andReturn(['not', 'a', 'string']);

    DB::shouldReceive('purge')->once()->with('mysql');
    DB::shouldReceive('reconnect')->once()->with('mysql');
    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Migration');

    $result = ArtisanService::act('migrate');

    expect($result)->toContain('Migration');
});
