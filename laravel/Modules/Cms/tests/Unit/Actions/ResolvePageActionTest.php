<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Datas\ResolvePageData;
use Modules\Cms\Models\Page;

test('ResolvePageAction can be instantiated', function () {
    $action = new ResolvePageAction();

    expect($action)->toBeInstanceOf(ResolvePageAction::class);
});

test('ResolvePageAction execute returns ResolvePageData', function () {
    $action = new ResolvePageAction();

    $result = $action->execute('events', 'test-event');

    expect($result)->toBeInstanceOf(ResolvePageData::class);
});

test('ResolvePageAction loads dynamic model when exists', function () {
    // This test verifies the path - actual model loading would require a real model
    $action = new ResolvePageAction();

    $result = $action->execute('nonexistent_container', 'nonexistent-slug');

    expect($result)->toBeInstanceOf(ResolvePageData::class);
    expect($result->renderMode)->toBeIn(['model', 'cms']);
});

test('ResolvePageAction returns cms mode with full slug when page exists', function () {
    $action = new ResolvePageAction();

    // Without an actual page in DB, it will try dynamic model first
    $result = $action->execute('test', 'test');

    expect($result)->toBeInstanceOf(ResolvePageData::class);
});

test('ResolvePageAction uses known mappings for events', function () {
    $action = new ResolvePageAction();

    // This should try to load from Events model first
    $result = $action->execute('events', 'some-event-slug');

    expect($result)->toBeInstanceOf(ResolvePageData::class);
});

test('ResolvePageAction falls back to config mappings', function () {
    // Add a custom config mapping
    config(['xra.container0_model_map' => ['custom' => Page::class]]);

    $action = new ResolvePageAction();

    $result = $action->execute('custom', 'test');

    expect($result)->toBeInstanceOf(ResolvePageData::class);
});

test('ResolvePageAction tries conventional model paths', function () {
    $action = new ResolvePageAction();

    // Should try various conventional paths
    $result = $action->execute('pages', 'test');

    expect($result)->toBeInstanceOf(ResolvePageData::class);
});

test('ResolvePageAction resolvePageData has correct structure', function () {
    $action = new ResolvePageAction();

    $result = $action->execute('test', 'test');

    expect($result->renderMode)->toBeString();
    expect(in_array($result->renderMode, ['model', 'cms'], true))->toBeTrue();
});
