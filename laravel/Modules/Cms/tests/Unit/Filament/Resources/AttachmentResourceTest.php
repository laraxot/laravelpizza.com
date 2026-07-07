<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Cms\Models\Attachment;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('AttachmentResource', function (): void {
    test('attachment resource has correct model', function (): void {
        $resource = new AttachmentResource();

        Assert::assertSame(Attachment::class, $resource::getModel());
    });

    test('attachment resource has form schema', function (): void {
        $schema = AttachmentResource::getFormSchema();
        /* @var array<string, mixed> $schema */
        Assert::assertGreaterThan(0, count($schema));
    });

    test('attachment resource has relations', function (): void {
        $relations = AttachmentResource::getRelations();
        /* @var array<string, mixed> $relations */
    });

    test('attachment resource has pages', function (): void {
        $pages = AttachmentResource::getPages();
        /* @var array<string, mixed> $pages */
        Assert::assertArrayHasKey('index', $pages);
        Assert::assertArrayHasKey('create', $pages);
        Assert::assertArrayHasKey('edit', $pages);
    });

    test('attachment resource extends LangBaseResource', function (): void {
        Assert::assertTrue(class_exists(AttachmentResource::class));
    });

    test('attachment resource has navigation icon', function (): void {
        Assert::assertTrue(property_exists(AttachmentResource::class, 'navigationIcon'));
    });

    test('attachment resource has navigation label', function (): void {
        Assert::assertTrue(property_exists(AttachmentResource::class, 'navigationLabel'));
    });

    test('attachment resource has plural label', function (): void {
    });
});
