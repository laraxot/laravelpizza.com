<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('saves tenant config by merging with existing data', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/path/to/tenant/database.php']);
    });

    File::shouldReceive('exists')
        ->with('/path/to/tenant/database.php')
        ->andReturn(true);

    File::shouldReceive('getRequire')
        ->with('/path/to/tenant/database.php')
        ->andReturn(['connections' => ['mysql' => ['host' => 'localhost']]]);

    $this->mockService(SaveArrayAction::class, static function (MockInterface $mock): void {
        TestCase::expectMockery($mock, 'execute')
            ->once()
            ->withArgs(static function (array $data, string $filename): bool {
                Assert::assertSame('/path/to/tenant/database.php', $filename);
                Assert::assertArrayHasKey('connections', $data);
                $connections = $data['connections'];
                Assert::assertIsArray($connections);
                Assert::assertArrayHasKey('mysql', $connections);
                $mysql = $connections['mysql'];
                Assert::assertIsArray($mysql);
                Assert::assertSame('localhost', $mysql['host'] ?? null);
                Assert::assertSame('test_db', $mysql['database'] ?? null);

                return true;
            });
    });

    app(SaveTenantConfigAction::class)->execute('database', [
        'connections' => ['mysql' => ['database' => 'test_db']],
    ]);
});

it('saves tenant config when file does not exist', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/path/to/tenant/app.php']);
    });

    File::shouldReceive('exists')
        ->with('/path/to/tenant/app.php')
        ->andReturn(false);

    $this->mockService(SaveArrayAction::class, static function (MockInterface $mock): void {
        TestCase::expectMockery($mock, 'execute')
            ->once()
            ->withArgs(static function (array $data, string $filename): bool {
                Assert::assertSame('/path/to/tenant/app.php', $filename);
                Assert::assertSame('Test App', $data['name']);

                return true;
            });
    });

    app(SaveTenantConfigAction::class)->execute('app', ['name' => 'Test App']);
});

it('replaces lists instead of merging them by index', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/path/to/tenant/progressioni.php']);
    });

    File::shouldReceive('exists')
        ->with('/path/to/tenant/progressioni.php')
        ->andReturn(true);

    File::shouldReceive('getRequire')
        ->with('/path/to/tenant/progressioni.php')
        ->andReturn([
            'anni' => [2023, 2024, 2025],
            'name' => 'Progressioni',
        ]);

    $this->mockService(SaveArrayAction::class, static function (MockInterface $mock): void {
        TestCase::expectMockery($mock, 'execute')
            ->once()
            ->withArgs(static function (array $data, string $filename): bool {
                Assert::assertSame('/path/to/tenant/progressioni.php', $filename);
                // Una lista salvata dal form e' lo stato completo: i vecchi elementi non devono restare.
                Assert::assertSame([2026], $data['anni']);
                // Le chiavi associative non inviate dal form restano.
                Assert::assertSame('Progressioni', $data['name']);

                return true;
            });
    });

    app(SaveTenantConfigAction::class)->execute('progressioni', ['anni' => [2026]]);
});
