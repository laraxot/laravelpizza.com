<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Tenant\Models\Traits\SushiToJsons;

use function Safe\class_uses;

describe('Section Business Logic', function (): void {
    test('section extends base model lang for multilingual support', function (): void {
        expect(Section::class)->toBeSubclassOf(BaseModelLang::class);
    });

    test('section has translatable fields configured', function (): void {
        $section = new Section;

        expect($section->translatable)->toEqual([
            'name',
            'blocks',
        ]);
    });

    test('section has expected fillable fields', function (): void {
        $section = new Section;
        $expectedFillable = [
            'name',
            'slug',
            'blocks',
        ];

        expect($section->getFillable())->toEqual($expectedFillable);
    });

    test('section has sushi to json trait', function (): void {
        $traits = class_uses(Section::class);

        expect($traits)->toHaveKey(SushiToJsons::class);
    });

    test('section has has blocks trait', function (): void {
        $traits = class_uses(Section::class);

        expect($traits)->toHaveKey(HasBlocks::class);
    });

    test('section has correct casts for multilingual and structured data', function (): void {
        $section = new Section;
        /** @phpstan-ignore-next-line method.nonObject */
        $casts = $section->getCasts();

        /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($casts['name'])->toBe('array');
        /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($casts['blocks'])->toBe('array');
        /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($casts['id'])->toBe('string');
    });

    test('section has schema definition for structured data', function (): void {
        $section = new Section;

        // Use reflection to access protected $schema property
        $reflection = new ReflectionClass($section);
        $schemaProperty = $reflection->getProperty('schema');

        expect($schemaProperty->isProtected())->toBeTrue();

        $schema = $schemaProperty->getValue($section);
        expect($schema)->toBeArray();
        expect($schema['name'])->toBe('json');
        expect($schema['blocks'])->toBe('json');
        expect($schema['slug'])->toBe('string');
    });

    test('section can get rows for sushi functionality', function (): void {
        $section = new Section;

        expect(method_exists($section, 'getRows'))->toBeTrue();
        expect($section->getRows())->toBeArray();
    });
});
