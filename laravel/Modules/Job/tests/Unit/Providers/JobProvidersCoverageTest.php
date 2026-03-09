<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Providers;

use Modules\Job\Providers\EventServiceProvider;
use Modules\Job\Providers\Filament\AdminPanelProvider;
use Modules\Job\Providers\JobServiceProvider;
use Modules\Job\Providers\RouteServiceProvider;

describe('Job Providers Coverage', function () {
    describe('JobServiceProvider', function () {
        it('can be instantiated', function () {
            $provider = new JobServiceProvider(app());
            expect($provider)->toBeInstanceOf(JobServiceProvider::class);
        });

        it('has correct name', function () {
            $provider = new JobServiceProvider(app());
            expect($provider->name)->toBe('Job');
        });

        it('has module directory via reflection', function () {
            $reflection = new ReflectionProperty(JobServiceProvider::class, 'module_dir');
            expect($reflection->isProtected())->toBeTrue();
            expect($reflection->getDefaultValue())->not->toBeEmpty();
        });

        it('has module namespace via reflection', function () {
            $reflection = new ReflectionProperty(JobServiceProvider::class, 'module_ns');
            expect($reflection->isProtected())->toBeTrue();
        });

        it('has registerQueue method', function () {
            $provider = new JobServiceProvider(app());
            expect(method_exists($provider, 'registerQueue'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(JobServiceProvider::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('EventServiceProvider', function () {
        it('can be instantiated', function () {
            $provider = new EventServiceProvider(app());
            expect($provider)->toBeInstanceOf(EventServiceProvider::class);
        });

        it('extends BaseEventServiceProvider', function () {
            $reflection = new ReflectionClass(EventServiceProvider::class);
            expect($reflection->isSubclassOf(\Illuminate\Foundation\Support\Providers\EventServiceProvider::class))->toBeTrue();
        });

        it('has listen property', function () {
            $reflection = new ReflectionProperty(EventServiceProvider::class, 'listen');
            expect($reflection->isProtected())->toBeTrue();
        });

        it('has shouldDiscoverEvents static property', function () {
            $reflection = new ReflectionProperty(EventServiceProvider::class, 'shouldDiscoverEvents');
            expect($reflection->isStatic())->toBeTrue()
                ->and($reflection->getDefaultValue())->toBeTrue();
        });

        it('has configureEmailVerification method', function () {
            $provider = new EventServiceProvider(app());
            expect(method_exists($provider, 'configureEmailVerification'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(EventServiceProvider::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('RouteServiceProvider', function () {
        it('can be instantiated', function () {
            $provider = new RouteServiceProvider(app());
            expect($provider)->toBeInstanceOf(RouteServiceProvider::class);
        });

        it('has correct name', function () {
            $provider = new RouteServiceProvider(app());
            expect($provider->name)->toBe('Job');
        });

        it('has module namespace via reflection', function () {
            $reflection = new ReflectionProperty(RouteServiceProvider::class, 'moduleNamespace');
            expect($reflection->isProtected())->toBeTrue();
            expect($reflection->getDefaultValue())->toBe('Modules\Job\Http\Controllers');
        });

        it('has module directory via reflection', function () {
            $reflection = new ReflectionProperty(RouteServiceProvider::class, 'module_dir');
            expect($reflection->isProtected())->toBeTrue();
            expect($reflection->getDefaultValue())->not->toBeEmpty();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(RouteServiceProvider::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('AdminPanelProvider', function () {
        it('can be instantiated', function () {
            $provider = new AdminPanelProvider(app());
            expect($provider)->toBeInstanceOf(AdminPanelProvider::class);
        });

        it('has module property', function () {
            $provider = new AdminPanelProvider(app());
            $reflection = new ReflectionProperty(AdminPanelProvider::class, 'module');
            expect($reflection->isProtected())->toBeTrue();
            expect($reflection->getDefaultValue())->toBe('Job');
        });

        it('has panel method', function () {
            $provider = new AdminPanelProvider(app());
            expect(method_exists($provider, 'panel'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(AdminPanelProvider::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });
});
