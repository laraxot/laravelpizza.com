<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\View\Components;

use Modules\Cms\Tests\TestCase;
use Modules\Cms\View\Components\Page;

uses(TestCase::class);

/**
 * Tests for Modules\Cms\View\Components\Page (the Blade VIEW component).
 *
 * Not to be confused with Modules\Cms\Tests\Unit\Models\PageTest
 * which tests the Page Eloquent model.
 *
 * @see \Modules\Cms\View\Components\Page
 * @see https://github.com/laraxot/laravelpizza.com/issues/544
 */
describe('Page component constructor', function () {
    test('can be instantiated with required params only', function () {
        $component = new Page('content', 'test-slug');

        expect($component)->toBeInstanceOf(Page::class);
    });

    test('accepts four constructor params: side, slug, type, data', function () {
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

    test('sets side property correctly', function () {
        $component = new Page('sidebar', 'test-slug');

        expect($component->side)->toBe('sidebar');
    });

    test('sets slug property correctly', function () {
        $component = new Page('content', 'my-page');

        expect($component->slug)->toBe('my-page');
    });

    test('prepends type to slug when type is provided', function () {
        $component = new Page('content', 'my-event', 'events');

        expect($component->slug)->toBe('events-my-event');
    });

    test('slug is unchanged when type is null', function () {
        $component = new Page('content', 'my-event', null);

        expect($component->slug)->toBe('my-event');
    });
});

describe('Page component public properties', function () {
    test('does not expose container0 as public property', function () {
        $component = new Page('content', 'test');

        expect(property_exists($component, 'container0'))->toBeFalse();
    });

    test('does not expose slug0 as public property', function () {
        $component = new Page('content', 'test');

        expect(property_exists($component, 'slug0'))->toBeFalse();
    });

    test('exposes data as public property', function () {
        $component = new Page('content', 'test');

        expect(property_exists($component, 'data'))->toBeTrue();
    });
});

describe('Page component $data carrier', function () {
    test('stores data array as-is', function () {
        $data = [
            'container0' => 'events',
            'slug0' => 'my-event',
        ];
        $component = new Page('content', 'test-slug', null, $data);

        expect($component->data)->toBe($data);
    });

    test('container0 is accessible via data array', function () {
        $component = new Page('content', 'test', null, [
            'container0' => 'events',
            'slug0' => 'my-event',
        ]);

        expect($component->data)->toHaveKey('container0', 'events');
        expect($component->data)->toHaveKey('slug0', 'my-event');
    });

    test('supports arbitrary context keys for future extensibility', function () {
        $component = new Page('content', 'test', null, [
            'container0' => 'events',
            'slug0' => 'my-event',
            'container1' => 'speakers',
            'slug1' => 'john-doe',
            'item' => null,
            'event' => null,
        ]);

        expect($component->data)->toHaveKey('container0');
        expect($component->data)->toHaveKey('container1');
        expect($component->data)->toHaveKey('slug1');
    });

    test('data defaults to empty array', function () {
        $component = new Page('content', 'test');

        expect($component->data)->toBe([]);
    });

    test('no resolveContext method exists', function () {
        expect(method_exists(Page::class, 'resolveContext'))->toBeFalse();
    });
});
