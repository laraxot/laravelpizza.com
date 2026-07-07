<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Support;

use Modules\Cms\Support\PageSchemaBuilder;
use Modules\Cms\Tests\TestCase;
use Modules\User\Models\User;
use Modules\Xot\Datas\MetatagData;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @param array<string, mixed> $schema
 *
 * @return array<string, mixed>
 */
function pageSchemaMainEntity(array $schema): array
{
    $mainEntity = $schema['mainEntity'] ?? null;
    if (! is_array($mainEntity)) {
        Assert::fail('Expected mainEntity array in schema');
    }

    $result = [];
    foreach ($mainEntity as $key => $value) {
        if (! is_string($key)) {
            continue;
        }

        $result[$key] = $value;
    }

    return $result;
}

describe('Page Schema Builder', function (): void {
    test('it resolves home as webpage', function (): void {
        $builder = new PageSchemaBuilder();
        $schema = $builder->build(
            meta: MetatagData::make(),
            routeName: 'home',
            path: '/',
        );

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('WebPage', $schema['@type']);
    });

    test('it resolves events index as collection page', function (): void {
        $builder = new PageSchemaBuilder();
        $schema = $builder->build(
            meta: MetatagData::make(),
            routeName: 'container0.index',
            path: 'it/events',
            routeParameters: ['container0' => 'events'],
        );

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('CollectionPage', $schema['@type']);
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

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('ItemPage', $schema['@type']);
        Assert::assertArrayHasKey('mainEntity', $schema);

        $mainEntity = pageSchemaMainEntity($schema);
        Assert::assertArrayHasKey('@type', $mainEntity);
        Assert::assertSame('Event', $mainEntity['@type']);
        Assert::assertStringContainsString('/events/test-event-slug', (string) ($mainEntity['url'] ?? ''));
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

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('ProfilePage', $schema['@type']);
        Assert::assertArrayHasKey('mainEntity', $schema);

        $mainEntity = pageSchemaMainEntity($schema);
        Assert::assertArrayHasKey('@type', $mainEntity);
        Assert::assertSame('Person', $mainEntity['@type']);
        Assert::assertArrayHasKey('name', $mainEntity);
        Assert::assertSame('Mario Rossi', $mainEntity['name']);
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

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('ProfilePage', $schema['@type']);
        Assert::assertArrayHasKey('mainEntity', $schema);

        $mainEntity = pageSchemaMainEntity($schema);
        Assert::assertArrayHasKey('@type', $mainEntity);
        Assert::assertSame('Person', $mainEntity['@type']);
        Assert::assertArrayHasKey('identifier', $mainEntity);
        Assert::assertSame('019cca1b-1f72-700a-ba0b-0bb414ca0c88', $mainEntity['identifier']);
    });

    test('it keeps auth routes as generic webpage', function (): void {
        $builder = new PageSchemaBuilder();
        $schema = $builder->build(
            meta: MetatagData::make(),
            routeName: 'auth.login',
            path: 'auth/login',
        );

        Assert::assertArrayHasKey('@type', $schema);
        Assert::assertSame('WebPage', $schema['@type']);
    });
});
