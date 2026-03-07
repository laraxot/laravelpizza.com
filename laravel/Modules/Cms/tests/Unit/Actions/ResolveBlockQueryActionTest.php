<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Actions\ResolveBlockQueryAction;
use Modules\Cms\Models\Page;

test('ResolveBlockQueryAction can be instantiated', function () {
    $action = new ResolveBlockQueryAction();

    expect($action)->toBeInstanceOf(ResolveBlockQueryAction::class);
});

test('ResolveBlockQueryAction returns empty array when model is null', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([]);

    expect($result)->toBe([]);
});

test('ResolveBlockQueryAction returns empty array when model class does not exist', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute(['model' => 'NonExistentModelClass']);

    expect($result)->toBe([]);
});

test('ResolveBlockQueryAction returns empty array when model class is invalid', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute(['model' => '']);

    expect($result)->toBe([]);
});

test('ResolveBlockQueryAction executes query with model', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'limit' => 10,
        'orderBy' => 'created_at',
        'direction' => 'desc',
    ]);

    expect($result)->toBeArray();
    expect($result)->toHaveKey('items');
    expect($result['items'])->toBeArray();
});

test('ResolveBlockQueryAction applies scopes', function () {
    $action = new ResolveBlockQueryAction();

    // Test with singular scope
    $result = $action->execute([
        'model' => Page::class,
        'scope' => 'published',
    ]);

    expect($result)->toBeArray();
});

test('ResolveBlockQueryAction applies scopes array', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'scopes' => [],
    ]);

    expect($result)->toBeArray();
});

test('ResolveBlockQueryAction applies orderBy and direction', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'orderBy' => 'updated_at',
        'direction' => 'asc',
    ]);

    expect($result)->toBeArray();
});

test('ResolveBlockQueryAction applies limit', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'limit' => 5,
    ]);

    expect($result)->toBeArray();
    expect($result)->toHaveKey('items');
});

test('ResolveBlockQueryAction uses default wrap_in value', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
    ]);

    expect($result)->toHaveKey('items');
});

test('ResolveBlockQueryAction uses custom wrap_in value', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'wrap_in' => 'pages',
    ]);

    expect($result)->toHaveKey('pages');
});

test('ResolveBlockQueryAction handles non-string wrap_in', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'wrap_in' => 123,
    ]);

    expect($result)->toHaveKey('items');
});
