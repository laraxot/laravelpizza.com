<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Xot\Filament\Resources\XotBaseResource;

test('cms resources extend proper base resources', function () {
    // Multilingual resources should extend LangBaseResource
    expect(PageResource::class)->toBeSubclassOf(LangBaseResource::class);

    expect(PageContentResource::class)->toBeSubclassOf(LangBaseResource::class);

    expect(SectionResource::class)->toBeSubclassOf(LangBaseResource::class);

    // Non-multilingual resources should extend XotBaseResource
    expect(MenuResource::class)->toBeSubclassOf(XotBaseResource::class);
});

test('cms resources inherit base resource methods properly', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);

        // These methods are inherited from base classes, which is correct behavior
        // The resources should NOT override form() or table() directly
        $formMethod = $reflection->getMethod('form');
        $tableMethod = $reflection->getMethod('table');

        // form() and table() should be declared in parent classes, not in the resource itself
        expect($formMethod->getDeclaringClass()->getName())->not->toBe($resourceClass);
        expect($tableMethod->getDeclaringClass()->getName())->not->toBe($resourceClass);
    }
});

test('cms resources implement required getFormSchema method', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);

        expect($reflection->hasMethod('getFormSchema'))->toBeTrue(
            "{$resourceClass} must implement getFormSchema()"
        );

        $method = $reflection->getMethod('getFormSchema');
        expect($method->isPublic())->toBeTrue(
            "{$resourceClass}::getFormSchema() must be public"
        );
        expect($method->isStatic())->toBeTrue(
            "{$resourceClass}::getFormSchema() must be static"
        );
        expect($method->getReturnType()?->getName())->toBe('array');
    }
});

test('cms resources have correct model configuration', function () {
    expect(PageResource::getModel())->toBe('Modules\\Cms\\Models\\Page');

    expect(PageContentResource::getModel())->toBe('Modules\\Cms\\Models\\PageContent');

    expect(SectionResource::getModel())->toBe('Modules\\Cms\\Models\\Section');

    expect(MenuResource::getModel())->toBe('Modules\\Cms\\Models\\Menu');
});

test('multilingual resources provide translatable locales', function () {
    $multilingualResources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
    ];

    foreach ($multilingualResources as $resourceClass) {
        $locales = $resourceClass::getTranslatableLocales();

        expect($locales)->toBeArray()->not->toBeEmpty();
        expect($locales)->toContain('it');
        expect($locales)->toContain('en');
    }
});

test('cms resource form schemas return valid arrays', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $schema = $resourceClass::getFormSchema();

        expect($schema)->toBeArray()->not->toBeEmpty();
    }
});

test('page resource form schema contains expected fields', function () {
    $schema = PageResource::getFormSchema();

    expect($schema)->toBeArray()->not->toBeEmpty();

    // Check for basic field structure
    $hasTitleField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && $field->getName() === 'title',
        );

    $hasSlugField = collect($schema)
        ->contains(fn ($field) => is_object($field) && method_exists($field, 'getName') && $field->getName() === 'slug');

    expect($hasTitleField)->toBeTrue('PageResource should have title field');
    expect($hasSlugField)->toBeTrue('PageResource should have slug field');
});

test('menu resource form schema contains expected fields', function () {
    $schema = MenuResource::getFormSchema();

    expect($schema)->toBeArray()->not->toBeEmpty();

    // Check for basic field structure
    $hasTitleField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && $field->getName() === 'title',
        );

    $hasItemsField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && $field->getName() === 'items',
        );

    expect($hasTitleField)->toBeTrue('MenuResource should have title field');
    expect($hasItemsField)->toBeTrue('MenuResource should have items field');
});

test('resources use proper base resource functionality', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $pages = $resourceClass::getPages();
        $relations = $resourceClass::getRelations();

        expect($pages)->toBeArray()->toHaveKeys(['index', 'create', 'edit']);
        expect($relations)->toBeArray();
    }
});

test('resources follow naming conventions', function () {
    expect(class_basename(PageResource::class))->toBe('PageResource');
    expect(class_basename(PageContentResource::class))->toBe('PageContentResource');
    expect(class_basename(SectionResource::class))->toBe('SectionResource');
    expect(class_basename(MenuResource::class))->toBe('MenuResource');

    // Test that model names are correctly derived
    expect(PageResource::getModel())->toBe('Modules\\Cms\\Models\\Page');
    expect(PageContentResource::getModel())->toBe('Modules\\Cms\\Models\\PageContent');
    expect(SectionResource::getModel())->toBe('Modules\\Cms\\Models\\Section');
    expect(MenuResource::getModel())->toBe('Modules\\Cms\\Models\\Menu');
});

test('lang base resource provides multilingual features', function () {
    $multilingualResources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
    ];

    foreach ($multilingualResources as $resourceClass) {
        // Test that multilingual methods are available
        expect(method_exists($resourceClass, 'getTranslatableLocales'))->toBeTrue();
        expect(method_exists($resourceClass, 'getDefaultTranslatableLocale'))->toBeTrue();

        $locales = $resourceClass::getTranslatableLocales();
        $defaultLocale = $resourceClass::getDefaultTranslatableLocale();

        expect($locales)->toBeArray()->not->toBeEmpty();
        expect($defaultLocale)->toBeString()->not->toBeEmpty();
    }
});
