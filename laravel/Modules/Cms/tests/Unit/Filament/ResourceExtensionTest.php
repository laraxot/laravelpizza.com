<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;

test('cms resources extend proper base resources', function () {
    foreach ([PageResource::class, PageContentResource::class, SectionResource::class] as $resourceClass) {
        Assert::assertTrue((new ReflectionClass($resourceClass))->isSubclassOf(LangBaseResource::class), "{$resourceClass} must extend LangBaseResource");
    }

    Assert::assertTrue((new ReflectionClass(MenuResource::class))->isSubclassOf(XotBaseResource::class));
});

test('cms resources inherit pages, relations, form and table from their base resource', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);

        // I metodi esistono (ereditati da XotBaseResource): la Resource non deve dichiararli lei.
        foreach (['getPages', 'getRelations', 'form', 'table'] as $method) {
            Assert::assertNotSame(
                $resourceClass,
                $reflection->getMethod($method)->getDeclaringClass()->getName(),
                "{$resourceClass} should not declare {$method}()",
            );
        }
    }
});

test('cms resources keep their form schema in the Schemas form class', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        // XotBaseResource::getFormSchema() e' final e vuoto: lo schema vive in `{Resource}\Schemas\{Model}Form`.
        $formClass = $resourceClass::getFormClass();

        Assert::assertSame($resourceClass, $formClass::getResource(), "{$formClass} must belong to {$resourceClass}");
    }
});

test('cms resources have correct model configuration', function () {
    Assert::assertSame('Modules\\Cms\\Models\\Page', PageResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\PageContent', PageContentResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\Section', SectionResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\Menu', MenuResource::getModel());
});

test('multilingual resources provide translatable locales', function () {
    $multilingualResources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
    ];

    foreach ($multilingualResources as $resourceClass) {
        $locales = $resourceClass::getTranslatableLocales();

        Assert::assertIsArray($locales, "{$resourceClass} must provide translatable locales");
        Assert::assertNotEmpty($locales, "{$resourceClass} must provide translatable locales");
        Assert::assertContains('it', $locales, "{$resourceClass} must support Italian and English locales");
        Assert::assertContains('en', $locales, "{$resourceClass} must support Italian and English locales");
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
        $formClass = $resourceClass::getFormClass();
        $schema = (new $formClass)->getFormSchema();

        Assert::assertNotEmpty($schema, "{$resourceClass} form class must return a non-empty schema");
    }
});

test('page resource form schema contains expected fields', function () {
    $formClass = PageResource::getFormClass();
    $schema = (new $formClass)->getFormSchema();

    Assert::assertNotEmpty($schema);

    $hasTitleField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && 'title' === $field->getName(),
        );

    $hasSlugField = collect($schema)
        ->contains(fn ($field) => is_object($field) && method_exists($field, 'getName') && 'slug' === $field->getName());

    Assert::assertTrue($hasTitleField, 'PageResource should have title field');
    Assert::assertTrue($hasSlugField, 'PageResource should have slug field');
});

test('menu resource form schema contains expected fields', function () {
    $formClass = MenuResource::getFormClass();
    $schema = (new $formClass)->getFormSchema();

    Assert::assertNotEmpty($schema);

    $hasTitleField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && 'title' === $field->getName(),
        );

    $hasItemsField = collect($schema)
        ->contains(
            fn ($field) => is_object($field) && method_exists($field, 'getName') && 'items' === $field->getName(),
        );

    Assert::assertTrue($hasTitleField, 'MenuResource should have title field');
    Assert::assertTrue($hasItemsField, 'MenuResource should have items field');
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

        Assert::assertIsArray($pages);
        Assert::assertArrayHasKey('index', $pages, "{$resourceClass} should have standard pages");
        Assert::assertArrayHasKey('create', $pages, "{$resourceClass} should have standard pages");
        Assert::assertArrayHasKey('edit', $pages, "{$resourceClass} should have standard pages");
        Assert::assertIsArray($relations, "{$resourceClass} should return relations array");
    }
});

test('resources follow naming conventions', function () {
    Assert::assertSame('PageResource', class_basename(PageResource::class));
    Assert::assertSame('PageContentResource', class_basename(PageContentResource::class));
    Assert::assertSame('SectionResource', class_basename(SectionResource::class));
    Assert::assertSame('MenuResource', class_basename(MenuResource::class));

    Assert::assertSame('Modules\\Cms\\Models\\Page', PageResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\PageContent', PageContentResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\Section', SectionResource::getModel());
    Assert::assertSame('Modules\\Cms\\Models\\Menu', MenuResource::getModel());
});

test('lang base resource provides multilingual features', function () {
    $multilingualResources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
    ];

    foreach ($multilingualResources as $resourceClass) {
        Assert::assertTrue(method_exists($resourceClass, 'getTranslatableLocales'));
        Assert::assertTrue(method_exists($resourceClass, 'getDefaultTranslatableLocale'));

        $locales = $resourceClass::getTranslatableLocales();
        $defaultLocale = $resourceClass::getDefaultTranslatableLocale();

        Assert::assertIsArray($locales);
        Assert::assertNotEmpty($locales);
        Assert::assertIsString($defaultLocale);
        Assert::assertNotSame('', $defaultLocale);
    }
});
