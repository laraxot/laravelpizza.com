<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Modules\Xot\Services\ArtisanService;
use Tests\TestCase;

use function Safe\ob_end_clean;
use function Safe\ob_start;

uses(TestCase::class);

beforeEach(function (): void {
    // Configure mysql connection for tests (required by ArtisanService)
    Config::set('database.connections.mysql', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
});

test('artisan service act method returns empty string for unknown commands', function (): void {
    Request::replace(['module' => '']);

    $result = ArtisanService::act('unknown-command');

    // @phpstan-ignore-next-line - Pest expectation method
    expect($result)->toBe('');
});

test('artisan service act method handles migrate command', function (): void {
    Request::replace(['module' => '']);

    // Mock Artisan facade - DB::purge() and DB::reconnect() work with configured connection
    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Migration completed');

    $result = ArtisanService::act('migrate');

    // @phpstan-ignore-next-line - Pest expectation method
    expect($result)->toBeString();
    /** @var string $result */
    // @phpstan-ignore-next-line - Pest expectation method
    expect(str_contains($result, 'Migration completed'))->toBeTrue();
});

test('artisan service act method handles module parameter', function (): void {
    Request::replace(['module' => 'TestModule']);

    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Module migration');

    ob_start();
    $result = ArtisanService::act('migrate');
    ob_end_clean();

    // @phpstan-ignore-next-line - Pest expectation method
    expect($result)->toBeString();
    /** @var string $result */
    // @phpstan-ignore-next-line - Pest expectation method
    expect(str_contains($result, 'Module migration'))->toBeTrue();
});

test('artisan service handles non-string module parameter', function (): void {
    Request::replace(['module' => ['not', 'a', 'string']]);

    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Migration');

    $result = ArtisanService::act('migrate');

    // @phpstan-ignore-next-line - Pest expectation method
    expect($result)->toBeString();
    /** @var string $result */
    // @phpstan-ignore-next-line - Pest expectation method
    expect(str_contains($result, 'Migration'))->toBeTrue();
});
