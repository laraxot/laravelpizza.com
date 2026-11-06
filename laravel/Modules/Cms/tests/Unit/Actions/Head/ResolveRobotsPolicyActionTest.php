<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Modules\Cms\Actions\Head\ResolveRobotsPolicyAction;
use PHPUnit\Framework\Assert;

test('private areas stay noindex however the path is written', function (string $path): void {
    $policy = new ResolveRobotsPolicyAction();

    Assert::assertFalse($policy->isIndexable($path, ['it', 'en']), $path);
})->with([
    'plain' => ['it/auth/login'],
    'upper-case locale and segment' => ['IT/Preview-Content'],
    'percent-encoded segment' => ['/it/%61uth/login'],
    'trailing and double slashes' => ['/en//profile/'],
    'no locale prefix' => ['dashboard'],
    'dot segment after the locale' => ['/it/./auth/login'],
    'dot segment before the area' => ['en/./dashboard'],
    'parent segment' => ['/it/blog/../auth/login'],
    'dot segment in a deeper position' => ['/it/./profile/./edit'],
]);

test('public pages are indexable, with and without the locale prefix', function (string $path): void {
    $policy = new ResolveRobotsPolicyAction();

    Assert::assertTrue($policy->isIndexable($path, ['it', 'en']), $path);
})->with(['', 'it', '/en/', 'it/faq', 'EN/Services/Radioprotezione', 'it/blog/some-post']);

test('path segments are decoded, lower-cased and stripped of the locale prefix', function (): void {
    $policy = new ResolveRobotsPolicyAction();

    Assert::assertSame(['servizi', 'radio protezione'], $policy->pathSegments('/IT/Servizi/Radio%20protezione/', ['it', 'en']));
    Assert::assertSame([], $policy->pathSegments('it', ['IT', 'EN']));
    Assert::assertSame(['de', 'faq'], $policy->pathSegments('de/faq', ['it', 'en']));
});

test('page rules hide test pages, auth pages, detail templates, redirect aliases and pages behind auth', function (string $slug, mixed $middleware, bool $expected): void {
    $policy = new ResolveRobotsPolicyAction();

    Assert::assertSame($expected, $policy->isPageIndexable($slug, $middleware), $slug);
})->with([
    'ordinary page' => ['faq', null, true],
    'nested page' => ['services.radioprotezione', [], true],
    'other middleware' => ['area', ['web'], true],
    'middleware is not a list' => ['area', 'auth', true],
    'empty slug' => ['', null, false],
    'tests root' => ['tests', null, false],
    'tests child' => ['tests.view', null, false],
    'auth child' => ['auth.login', null, false],
    'detail template' => ['blog.view', null, false],
    'hidden slug' => ['tickets.confirmation', null, false],
    'redirect alias' => ['segnalazioni.index', null, false],
    'behind auth' => ['profile-settings', ['web', 'auth'], false],
]);

test('the robots directive follows the decision', function (): void {
    $policy = new ResolveRobotsPolicyAction();

    Assert::assertSame('noindex, follow', $policy->directive(false));
    Assert::assertSame('index, follow, max-image-preview:large', $policy->directive(true));
    Assert::assertSame('noindex, follow', $policy->execute('it/faq', ['it', 'en'], false));
});
