<?php

declare(strict_types=1);

use Modules\Job\Providers\EventServiceProvider;
use Modules\Job\Providers\JobServiceProvider;
use Modules\Job\Providers\RouteServiceProvider;
use Modules\Job\Providers\Filament\AdminPanelProvider;

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

        it('has registerQueue method', function () {
            $provider = new JobServiceProvider(app());
            expect(method_exists($provider, 'registerQueue'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(JobServiceProvider::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
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
            $provider = new EventServiceProvider(app());
            $reflection = new ReflectionProperty($provider, 'listen');
            expect($reflection->isPublic())->toBeTrue();
        });

        it('has shouldDiscoverEvents static property', function () {
            expect(EventServiceProvider::$shouldDiscoverEvents)->toBeTrue();
        });

        it('has configureEmailVerification method', function () {
            $provider = new EventServiceProvider(app());
            expect(method_exists($provider, 'configureEmailVerification'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(EventServiceProvider::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
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

        it('has module namespace', function () {
            $provider = new RouteServiceProvider(app());
            expect($provider->moduleNamespace)->toBe('Modules\Job\Http\Controllers');
        });

        it('has module directory', function () {
            $provider = new RouteServiceProvider(app());
            expect($provider->module_dir)->not->toBeEmpty();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(RouteServiceProvider::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('AdminPanelProvider', function () {
        it('can be instantiated', function () {
            $provider = new AdminPanelProvider(app());
            expect($provider)->toBeInstanceOf(AdminPanelProvider::class);
        });

        it('has module property', function () {
            $provider = new AdminPanelProvider(app());
            $reflection = new ReflectionProperty($provider, 'module');
            expect($reflection->isPublic())->toBeTrue();
            expect($provider->module)->toBe('Job');
        });

        it('has panel method', function () {
            $provider = new AdminPanelProvider(app());
            expect(method_exists($provider, 'panel'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(AdminPanelProvider::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });
});
