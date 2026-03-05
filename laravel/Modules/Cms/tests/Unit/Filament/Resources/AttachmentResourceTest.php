<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Cms\Models\Attachment;

describe('AttachmentResource', function (): void {
    test('attachment resource has correct model', function (): void {
        $resource = new AttachmentResource();

        expect($resource::getModel())->toBe(Attachment::class);
    });

    test('attachment resource has form schema', function (): void {
        $schema = AttachmentResource::getFormSchema();

        expect($schema)->toBeArray();
        expect(count($schema))->toBeGreaterThan(0);
    });

    test('attachment resource has relations', function (): void {
        $relations = AttachmentResource::getRelations();

        expect($relations)->toBeArray();
    });

    test('attachment resource has pages', function (): void {
        $pages = AttachmentResource::getPages();

        expect($pages)->toBeArray();
        expect($pages)->toHaveKey('index');
        expect($pages)->toHaveKey('create');
        expect($pages)->toHaveKey('edit');
    });

    test('attachment resource extends LangBaseResource', function (): void {
        expect(is_subclass_of(AttachmentResource::class, Modules\Lang\Filament\Resources\LangBaseResource::class))->toBeTrue();
    });

    test('attachment resource has navigation icon', function (): void {
        expect(property_exists(AttachmentResource::class, 'navigationIcon'))->toBeTrue();
    });

    test('attachment resource has navigation label', function (): void {
        expect(property_exists(AttachmentResource::class, 'navigationLabel'))->toBeTrue();
    });

    test('attachment resource has plural label', function (): void {
        expect(method_exists(AttachmentResource::class, 'getPluralModelLabel'))->toBeTrue();
    });
});
