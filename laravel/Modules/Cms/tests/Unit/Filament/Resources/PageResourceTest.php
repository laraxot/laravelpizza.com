<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Models\Page;

describe('PageResource', function (): void {
    test('page resource has correct model', function (): void {
        $resource = new PageResource();

        expect($resource::getModel())->toBe(Page::class);
    });

    test('page resource has form schema', function (): void {
        $schema = PageResource::getFormSchema();

        expect($schema)->toBeArray();
        expect(count($schema))->toBeGreaterThan(0);
    });

    test('page resource has form fields', function (): void {
        $schema = PageResource::getFormSchema();

        // Check that form has required components (check array keys)
        expect(array_keys($schema))->toContain('title')
            ->toContain('slug')
            ->toContain('content');
    });

    test('page resource extends LangBaseResource', function (): void {
        expect(is_subclass_of(PageResource::class, Modules\Lang\Filament\Resources\LangBaseResource::class))->toBeTrue();
    });
});
