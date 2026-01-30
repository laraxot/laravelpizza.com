<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);
use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Page;
use Modules\Tenant\Models\Traits\SushiToJsons;

use function Safe\class_uses;

describe('Page Business Logic', function (): void {
    test('page extends base model lang for multilingual support', function (): void {
        expect(Page::class)->toBeSubclassOf(BaseModelLang::class);
    });

    test('page has translatable fields configured', function (): void {
        $page = new Page();

        expect($page->translatable)->toEqual([
            'title',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ]);
    });

    test('page has expected fillable fields', function (): void {
        $page = new Page();
        $expectedFillable = [
            'content',
            'description',
            'slug',
            'title',
            'middleware',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ];

        expect($page->getFillable())->toEqual($expectedFillable);
    });

    test('page has sushi to json trait', function (): void {
        $traits = class_uses(Page::class);

        expect($traits)->toHaveKey(SushiToJsons::class);
    });

    test('page can get middleware by slug', function (): void {
        $middleware = Page::getMiddlewareBySlug('non-existent-slug');

        expect($middleware)->toBeArray();
    });

    test('page has correct casts for blocks and arrays', function (): void {
        $page = new Page();
        /** @phpstan-ignore-next-line method.nonObject */
        $casts = $page->getCasts();

        /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($casts['content_blocks'])->toBe('array');
        /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($casts['sidebar_blocks'])->toBe('array');
        /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($casts['footer_blocks'])->toBe('array');
        /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
        expect($casts['middleware'])->toBe('array');
    });

    test('page has schema definition for structured data', function (): void {
        $page = new Page();

        // Use reflection to access protected $schema property
        $reflection = new ReflectionClass($page);
        $schemaProperty = $reflection->getProperty('schema');

        expect($schemaProperty->isProtected())->toBeTrue();

        $schema = $schemaProperty->getValue($page);
        expect($schema)->toBeArray();
        expect($schema['content_blocks'])->toBe('json');
        expect($schema['sidebar_blocks'])->toBe('json');
        expect($schema['footer_blocks'])->toBe('json');
    });

    test('page can get rows for sushi functionality', function (): void {
        $page = new Page();

        expect(method_exists($page, 'getRows'))->toBeTrue();
    });
});
