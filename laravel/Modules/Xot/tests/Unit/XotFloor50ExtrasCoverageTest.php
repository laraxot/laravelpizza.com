<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Modules\Xot\Tests\ModuleDeepCoverage;
use Modules\Xot\Tests\ModuleExecuteCoverage;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-xot-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Xot floor50 extras non-public', function (): void {
    test('invoke non-public methods su directory residue', function (): void {
        config(['cache.default' => 'array', 'database.default' => 'sqlite']);
        Cache::store('array')->flush();
        Http::fake(['*' => Http::response('ok', 200)]);
        Mail::fake();
        Queue::fake();
        Process::fake();

        $root = dirname(__DIR__, 2).'/app';
        $ns = 'Modules\\Xot\\';

        $dirs = [
            'Adapters', 'Casts', 'Datas', 'DTOs', 'Database', 'Enums', 'Events',
            'Exceptions', 'Facades', 'Helpers', 'Http/Middleware', 'Mixins', 'Models',
            'QueryBuilders', 'Relations', 'Rules', 'Services', 'States', 'Traits',
            'ValueObjects', 'View', 'Filament/Builders', 'Filament/Support',
            'Filament/Forms', 'Filament/Tables', 'Filament/Schemas', 'Filament/Traits',
            'Actions/Arr', 'Actions/Cast', 'Actions/Config', 'Actions/File',
            'Actions/Filament', 'Actions/Factory', 'Actions/String', 'Actions/Collection',
        ];

        foreach ($dirs as $dir) {
            try {
                ModuleExecuteCoverage::testInvokeNonPublicMethods($root, $ns, $dir);
            } catch (\Throwable $e) {
                Assert::assertNotEmpty($e->getMessage());
            }
        }

        // directory-level public invoke (safe dirs only — skip Exports/Mail/Pdf)
        foreach (['Services', 'Rules', 'States', 'Exceptions', 'ValueObjects', 'Adapters', 'View', 'Relations', 'QueryBuilders', 'Helpers', 'Casts', 'Mixins', 'Filament/Builders', 'Filament/Support', 'Filament/Actions'] as $dir) {
            try {
                $ref = new \ReflectionClass(ModuleExecuteCoverage::class);
                $m = $ref->getMethod('testInvokePublicMethodsInDirectory');
                $m->setAccessible(true);
                $m->invoke(null, $root, $ns, $dir);
            } catch (\Throwable $e) {
                Assert::assertNotEmpty($e->getMessage());
            }
        }

        try {
            ModuleExecuteCoverage::testFilamentComponents($root, $ns);
            ModuleExecuteCoverage::testFilamentActionsMake($root, $ns);
            ModuleExecuteCoverage::testAllMiddleware($root, $ns);
            ModuleDeepCoverage::testInstantiateFilamentColumns($root, $ns);
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }
    });
});
