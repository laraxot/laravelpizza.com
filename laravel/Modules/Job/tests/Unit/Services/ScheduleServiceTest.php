<?php

declare(strict_types=1);

use Modules\Job\Services\ScheduleService;

describe('ScheduleService', function () {
    it('can be instantiated', function () {
        $reflection = new ReflectionClass(ScheduleService::class);
        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has getActives method', function () {
        $reflection = new ReflectionClass(ScheduleService::class);
        expect($reflection->hasMethod('getActives'))->toBeTrue();
    });

    it('has clearCache method', function () {
        $reflection = new ReflectionClass(ScheduleService::class);
        expect($reflection->hasMethod('clearCache'))->toBeTrue();
    });

    it('has private getFromCache method', function () {
        $reflection = new ReflectionClass(ScheduleService::class);
        expect($reflection->hasMethod('getFromCache'))->toBeTrue();
        $method = $reflection->getMethod('getFromCache');
        expect($method->isPrivate())->toBeTrue();
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
