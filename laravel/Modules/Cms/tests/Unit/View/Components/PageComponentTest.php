<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\View\Components;

use Modules\Cms\View\Components\Page;

/*
 * Pure unit tests for Modules\Cms\View\Components\Page (the Blade VIEW component).
 *
 * Uses only reflection — no database required.
 * For integration tests (constructor that queries DB), see Feature tests.
 *
 * Not to be confused with Modules\Cms\Tests\Unit\Models\PageTest
 * which tests the Page Eloquent model.
 *
 * @see \Modules\Cms\View\Components\Page
 * @see https://github.com/laraxot/laravelpizza.com/issues/544
 */

describe('Page component contract — constructor signature', function () {
    test('has exactly four constructor params: side, slug, type, data', function () {
        $reflection = new \ReflectionMethod(Page::class, '__construct');
        $paramNames = array_map(fn ($p) => $p->getName(), $reflection->getParameters());

        expect($paramNames)->toBe(['side', 'slug', 'type', 'data']);
        expect($reflection->getParameters())->toHaveCount(4);
    });

    test('does not have container0 as constructor param', function () {
        $reflection = new \ReflectionMethod(Page::class, '__construct');
        $paramNames = array_map(fn ($p) => $p->getName(), $reflection->getParameters());

        expect($paramNames)->not->toContain('container0');
    });

    test('does not have slug0 as constructor param', function () {
        $reflection = new \ReflectionMethod(Page::class, '__construct');
        $paramNames = array_map(fn ($p) => $p->getName(), $reflection->getParameters());

        expect($paramNames)->not->toContain('slug0');
    });

    test('type param is nullable (optional)', function () {
        $reflection = new \ReflectionMethod(Page::class, '__construct');
        $params = $reflection->getParameters();
        $typeParam = $params[2]; // third param = type

        expect($typeParam->getName())->toBe('type');
        expect($typeParam->allowsNull())->toBeTrue();
    });

    test('data param defaults to empty array', function () {
        $reflection = new \ReflectionMethod(Page::class, '__construct');
        $params = $reflection->getParameters();
        $dataParam = $params[3]; // fourth param = data

        expect($dataParam->getName())->toBe('data');
        expect($dataParam->isDefaultValueAvailable())->toBeTrue();
        expect($dataParam->getDefaultValue())->toBe([]);
    });
});

describe('Page component contract — public properties', function () {
    test('has public property: side', function () {
        $reflection = new \ReflectionClass(Page::class);

        expect($reflection->hasProperty('side'))->toBeTrue();
        expect($reflection->getProperty('side')->isPublic())->toBeTrue();
    });

    test('has public property: slug', function () {
        $reflection = new \ReflectionClass(Page::class);

        expect($reflection->hasProperty('slug'))->toBeTrue();
        expect($reflection->getProperty('slug')->isPublic())->toBeTrue();
    });

    test('has public property: data (the context carrier)', function () {
        $reflection = new \ReflectionClass(Page::class);

        expect($reflection->hasProperty('data'))->toBeTrue();
        expect($reflection->getProperty('data')->isPublic())->toBeTrue();
    });

    test('data property defaults to empty array', function () {
        $reflection = new \ReflectionClass(Page::class);
        $defaults = $reflection->getDefaultProperties();

        expect($defaults['data'])->toBe([]);
    });

    test('does NOT have public property container0', function () {
        expect(property_exists(Page::class, 'container0'))->toBeFalse();
    });

    test('does NOT have public property slug0', function () {
        expect(property_exists(Page::class, 'slug0'))->toBeFalse();
    });
});

describe('Page component contract — removed methods', function () {
    test('resolveContext() has been removed', function () {
        expect(method_exists(Page::class, 'resolveContext'))->toBeFalse();
    });
});
