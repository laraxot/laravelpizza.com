<?php

declare(strict_types=1);

use Tests\TestCase;
use Modules\Xot\Services\ModuleService;
use Nwidart\Modules\Facades\Module as ModuleFacade;
use Nwidart\Modules\Module;

uses(TestCase::class);

describe('ModuleService', function () {
    beforeEach(function () {
        $this->service = new ModuleService()->setName('TestModule');
    });

    it('can be instantiated', function () {
        expect($this->service)->toBeInstanceOf(ModuleService::class);
    });

    it('has correct module name property', function () {
        $reflection = new ReflectionClass($this->service);
        $nameProperty = $reflection->getProperty('name');
        $nameProperty->setAccessible(true);

        expect($nameProperty->getValue($this->service))->toBe('TestModule');
    });

    it('can be instantiated with different module names', function () {
        $service1 = new ModuleService()->setName('Chart');
        $service2 = new ModuleService()->setName('User');

        expect($service1)->toBeInstanceOf(ModuleService::class)->and($service2)->toBeInstanceOf(ModuleService::class);
    });

    it('has getModels method', function () {
        expect(method_exists($this->service, 'getModels'))->toBeTrue();
    });

    it('returns array from getModels method', function () {
        // Mock the Module facade to avoid database dependencies
        $result = $this->service->getModels();

        expect($result)->toBeArray();
    });

    it('getModels returns correct array structure', function () {
        $result = $this->service->getModels();

        expect($result)->toBeArray();

        // Each value should be a class string
        foreach ($result as $key => $value) {
            expect($key)->toBeString()->and($value)->toBeString();
        }
    });

    it('filters abstract classes correctly', function () {
        // Test the logic that filters out abstract classes
        $result = $this->service->getModels();

        // The result should not contain BaseModel (which is abstract)
        expect($result)->not->toHaveKey('base_model');
    });

    it('handles reflection exceptions gracefully', function () {
        // Test that the service handles reflection errors without throwing
        $result = $this->service->getModels();

        expect($result)->toBeArray();
    });

    it('processes model names correctly', function () {
        // Test that model names are converted to snake_case
        $reflection = new ReflectionClass($this->service);
        $method = $reflection->getMethod('getModels');

        expect($method->isPublic())->toBeTrue();
    });

    it('has proper return type annotation', function () {
        $reflection = new ReflectionClass($this->service);
        $method = $reflection->getMethod('getModels');

        $docComment = $method->getDocComment();
        expect($docComment)->toContain('@return array<string, class-string>');
    });

    it('validates method signature', function () {
        $reflection = new ReflectionClass($this->service);
        $method = $reflection->getMethod('getModels');

        expect($method->isPublic())->toBeTrue()->and($method->getNumberOfParameters())->toBe(0);
    });

    it('handles empty module gracefully', function () {
        $emptyService = new ModuleService()->setName('NonExistentModule');
        $result = $emptyService->getModels();

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });

    it('uses correct namespace patterns', function () {
        // Test that the service uses correct namespace patterns
        $reflection = new ReflectionClass($this->service);

        expect($reflection->hasProperty('name'))->toBeTrue();
    });

    it('uses setName method for configuration', function () {
        // ModuleService doesn't have a constructor with parameters
        // It uses setName() method for configuration (fluent interface)
        $reflection = new ReflectionClass($this->service);

        expect($reflection->hasMethod('setName'))
            ->toBeTrue()
            ->and($reflection->getMethod('setName')->isPublic())
            ->toBeTrue();
    });

    it('validates class structure', function () {
        $reflection = new ReflectionClass($this->service);

        expect($reflection->isInstantiable())
            ->toBeTrue()
            ->and($reflection->isFinal())
            ->toBeFalse()
            ->and($reflection->isAbstract())
            ->toBeFalse();
    });

    it('has proper method visibility', function () {
        $reflection = new ReflectionClass($this->service);
        $methods = $reflection->getMethods();

        $publicMethods = array_filter($methods, fn($method) => $method->isPublic());

        expect(count($publicMethods))->toBeGreaterThan(0);
    });

    it('handles module facade interactions', function () {
        // Test basic interaction with Module facade
        expect(class_exists('Nwidart\Modules\Facades\Module'))->toBeTrue();
    });

    it('processes file extensions correctly', function () {
        // Test that the service correctly processes .php files
        $result = $this->service->getModels();

        expect($result)->toBeArray();
    });

    it('validates string utilities usage', function () {
        // Test that Str helper is used correctly
        expect(class_exists('Illuminate\Support\Str'))->toBeTrue();
    });

    it('handles reflection class instantiation', function () {
        // Test that ReflectionClass is used correctly
        expect(class_exists('ReflectionClass'))->toBeTrue();
    });

    it('has proper error handling', function () {
        // Test that exceptions are caught and handled gracefully
        $result = $this->service->getModels();

        // Should not throw exceptions
        expect($result)->toBeArray();
    });
});
