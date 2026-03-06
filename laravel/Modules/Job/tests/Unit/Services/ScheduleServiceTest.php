<?php

declare(strict_types=1);

use Modules\Job\Services\ScheduleService;

describe('ScheduleService', function () {
    it('can be instantiated via container', function () {
        $service = app(ScheduleService::class);
        expect($service)->toBeInstanceOf(ScheduleService::class);
    });

    it('has getActives method', function () {
        $service = app(ScheduleService::class);
        expect(method_exists($service, 'getActives'))->toBeTrue();
    });

    it('has clearCache method', function () {
        $service = app(ScheduleService::class);
        expect(method_exists($service, 'clearCache'))->toBeTrue();
    });

    it('getActives returns collection', function () {
        $service = app(ScheduleService::class);
        $result = $service->getActives();
        expect($result)->toBeInstanceOf(\Illuminate\Support\Collection::class);
    });

    it('clearCache method is callable', function () {
        $service = app(ScheduleService::class);
        expect(fn () => $service->clearCache())->not->toThrow();
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(ScheduleService::class);
        $content = file_get_contents($reflection->getFileName());
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(ScheduleService::class);
        expect($reflection->getNamespaceName())->toBe('Modules\Job\Services');
    });

    it('has model property', function () {
        $reflection = new ReflectionClass(ScheduleService::class);
        expect($reflection->hasProperty('model'))->toBeTrue();
    });
});
