<?php

declare(strict_types=1);

use Modules\Cms\View\Components\Page;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
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
        $reflection = new ReflectionMethod(Page::class, '__construct');
        $paramNames = array_map(fn ($p) => $p->getName(), $reflection->getParameters());

        Assert::assertSame(['side', 'slug', 'type', 'data'], $paramNames);
        Assert::assertCount(4, $reflection->getParameters());
    });

    test('does not have container0 as constructor param', function () {
        $reflection = new ReflectionMethod(Page::class, '__construct');
        $paramNames = array_map(fn ($p) => $p->getName(), $reflection->getParameters());

        Assert::assertNotContains('container0', $paramNames);
    });

    test('does not have slug0 as constructor param', function () {
        $reflection = new ReflectionMethod(Page::class, '__construct');
        $paramNames = array_map(fn ($p) => $p->getName(), $reflection->getParameters());

        Assert::assertNotContains('slug0', $paramNames);
    });

    test('type param is nullable (optional)', function () {
        $reflection = new ReflectionMethod(Page::class, '__construct');
        $params = $reflection->getParameters();
        $typeParam = $params[2]; // third param = type

        Assert::assertSame('type', $typeParam->getName());
        Assert::assertTrue($typeParam->allowsNull());
    });

    test('data param defaults to empty array', function () {
        $reflection = new ReflectionMethod(Page::class, '__construct');
        $params = $reflection->getParameters();
        $dataParam = $params[3]; // fourth param = data

        Assert::assertSame('data', $dataParam->getName());
        Assert::assertTrue($dataParam->isDefaultValueAvailable());
        Assert::assertSame([], $dataParam->getDefaultValue());
    });
});

describe('Page component contract — public properties', function () {
    test('has public property: side', function () {
        $reflection = new ReflectionClass(Page::class);

        Assert::assertTrue($reflection->hasProperty('side'));
        Assert::assertTrue($reflection->getProperty('side')->isPublic());
    });

    test('has public property: slug', function () {
        $reflection = new ReflectionClass(Page::class);

        Assert::assertTrue($reflection->hasProperty('slug'));
        Assert::assertTrue($reflection->getProperty('slug')->isPublic());
    });

    test('has public property: data (the context carrier)', function () {
        $reflection = new ReflectionClass(Page::class);

        Assert::assertTrue($reflection->hasProperty('data'));
        Assert::assertTrue($reflection->getProperty('data')->isPublic());
    });

    test('data property defaults to empty array', function () {
        $reflection = new ReflectionClass(Page::class);
        $defaults = $reflection->getDefaultProperties();

        Assert::assertSame([], $defaults['data']);
    });

    test('does NOT have public property container0', function () {
        Assert::assertFalse(property_exists(Page::class, 'container0'));
    });

    test('does NOT have public property slug0', function () {
        Assert::assertFalse(property_exists(Page::class, 'slug0'));
    });
});

describe('Page component contract — removed methods', function () {
    test('resolveContext() has been removed', function () {
        Assert::assertFalse((new ReflectionClass(Page::class))->hasMethod('resolveContext'));
    });
});
