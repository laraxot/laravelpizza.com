<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Support;

use Modules\Cms\Support\PageSchemaBuilder;
use Modules\Cms\Tests\TestCase;
use Modules\User\Models\User;
use Modules\Xot\Datas\MetatagData;

uses(TestCase::class);

test('it resolves home as webpage', function (): void {
    $builder = new PageSchemaBuilder();
    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'home',
        path: '/',
    );

    expect($schema)->toHaveKey('@type', 'WebPage');
});

test('it resolves events index as collection page', function (): void {
    $builder = new PageSchemaBuilder();
    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'container0.index',
        path: 'it/events',
        routeParameters: ['container0' => 'events'],
    );

    expect($schema)->toHaveKey('@type', 'CollectionPage');
});

test('it resolves event detail as item page with main entity', function (): void {
    $builder = new PageSchemaBuilder();
    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'container0.view',
        path: 'it/events/test-event-slug',
        routeParameters: [
            'container0' => 'events',
            'slug0' => 'test-event-slug',
        ],
    );

    expect($schema)->toHaveKey('@type', 'ItemPage')
        ->and($schema)->toHaveKey('mainEntity')
        ->and($schema['mainEntity'])->toHaveKey('@type', 'Event')
        ->and($schema['mainEntity']['url'])->toContain('/events/test-event-slug');
});

test('it resolves profile route as profile page with person main entity', function (): void {
    $builder = new PageSchemaBuilder();
    $user = new User([
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'name' => 'Mario Rossi',
    ]);

    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'profile.edit',
        path: 'profile/edit',
        user: $user,
    );

    expect($schema)->toHaveKey('@type', 'ProfilePage')
        ->and($schema)->toHaveKey('mainEntity')
        ->and($schema['mainEntity'])->toHaveKey('@type', 'Person')
        ->and($schema['mainEntity'])->toHaveKey('name', 'Mario Rossi');
});

test('it resolves public profile detail route as profile page with person identifier', function (): void {
    $builder = new PageSchemaBuilder();

    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'container0.view',
        path: 'it/profile/019cca1b-1f72-700a-ba0b-0bb414ca0c88',
        routeParameters: [
            'container0' => 'profile',
            'slug0' => '019cca1b-1f72-700a-ba0b-0bb414ca0c88',
        ],
    );

    expect($schema)->toHaveKey('@type', 'ProfilePage')
        ->and($schema)->toHaveKey('mainEntity')
        ->and($schema['mainEntity'])->toHaveKey('@type', 'Person')
        ->and($schema['mainEntity'])->toHaveKey('identifier', '019cca1b-1f72-700a-ba0b-0bb414ca0c88');
});

test('it keeps auth routes as generic webpage', function (): void {
    $builder = new PageSchemaBuilder();
    $schema = $builder->build(
        meta: MetatagData::make(),
        routeName: 'auth.login',
        path: 'auth/login',
    );

    expect($schema)->toHaveKey('@type', 'WebPage');
});
