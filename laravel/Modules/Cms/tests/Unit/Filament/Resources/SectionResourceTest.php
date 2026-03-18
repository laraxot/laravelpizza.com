<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Filament\Resources;

use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Cms\Models\Section;

describe('SectionResource', function (): void {
    test('section resource has correct model', function (): void {
        $resource = new SectionResource();

        expect($resource::getModel())->toBe(Section::class);
    });

    test('section resource has form schema', function (): void {
        $schema = SectionResource::getFormSchema();

        expect($schema)->toBeArray();
        expect(count($schema))->toBeGreaterThan(0);
    });

    test('section resource has form fields', function (): void {
        $schema = SectionResource::getFormSchema();

        // Check that form has required components (check array keys)
        expect(array_keys($schema))->toContain('info')
            ->toContain('blocks');
    });

    test('section resource extends LangBaseResource', function (): void {
        expect(is_subclass_of(SectionResource::class, Modules\Lang\Filament\Resources\LangBaseResource::class))->toBeTrue();
    });
});
