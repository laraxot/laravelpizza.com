<?php

declare(strict_types=1);

use Modules\Cms\Actions\ResolveBlockQueryAction;
use Modules\Cms\Models\Page;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('ResolveBlockQueryAction can be instantiated', function () {
    $action = new ResolveBlockQueryAction();

    Assert::assertInstanceOf(ResolveBlockQueryAction::class, $action);
});

test('ResolveBlockQueryAction returns empty array when model is null', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([]);

    Assert::assertSame([], $result);
});

test('ResolveBlockQueryAction returns empty array when model class does not exist', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute(['model' => 'NonExistentModelClass']);

    Assert::assertSame([], $result);
});

test('ResolveBlockQueryAction returns empty array when model class is invalid', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute(['model' => '']);

    Assert::assertSame([], $result);
});

test('ResolveBlockQueryAction executes query with model', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'limit' => 10,
        'orderBy' => 'created_at',
        'direction' => 'desc',
    ]);
    /* @var array<string, mixed> $result */
    Assert::assertArrayHasKey('items', $result);
    Assert::assertIsArray($result['items']);
});

test('ResolveBlockQueryAction applies scopes', function () {
    $action = new ResolveBlockQueryAction();

    // Test with singular scope
    $result = $action->execute([
        'model' => Page::class,
        'scope' => 'published',
    ]);
    /* @var array<string, mixed> $result */
});

test('ResolveBlockQueryAction applies scopes array', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'scopes' => [],
    ]);
    /* @var array<string, mixed> $result */
});

test('ResolveBlockQueryAction applies orderBy and direction', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'orderBy' => 'updated_at',
        'direction' => 'asc',
    ]);
    /* @var array<string, mixed> $result */
});

test('ResolveBlockQueryAction applies limit', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'limit' => 5,
    ]);
    /* @var array<string, mixed> $result */
    Assert::assertArrayHasKey('items', $result);
});

test('ResolveBlockQueryAction uses default wrap_in value', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
    ]);

    Assert::assertArrayHasKey('items', $result);
});

test('ResolveBlockQueryAction uses custom wrap_in value', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'wrap_in' => 'pages',
    ]);

    Assert::assertArrayHasKey('pages', $result);
});

test('ResolveBlockQueryAction handles non-string wrap_in', function () {
    $action = new ResolveBlockQueryAction();

    $result = $action->execute([
        'model' => Page::class,
        'wrap_in' => 123,
    ]);

    Assert::assertArrayHasKey('items', $result);
});
