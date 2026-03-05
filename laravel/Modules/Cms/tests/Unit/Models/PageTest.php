<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Models\Page;

describe('Page Model', function (): void {
    test('page model can be instantiated', function (): void {
        $page = new Page();

        expect($page)->toBeInstanceOf(Page::class);
    });

    test('page model has expected fillable fields', function (): void {
        $page = new Page();

        $fillable = $page->getFillable();

        expect($fillable)->toContain('title')
            ->and($fillable)->toContain('slug')
            ->and($fillable)->toContain('content')
            ->and($fillable)->toContain('description')
            ->and($fillable)->toContain('middleware')
            ->and($fillable)->toContain('blocks')
            ->and($fillable)->toContain('content_blocks')
            ->and($fillable)->toContain('sidebar_blocks')
            ->and($fillable)->toContain('footer_blocks');
    });

    test('page model has expected casts', function (): void {
        $page = new Page();

        $casts = $page->getCasts();

        expect($casts)->toHaveKey('content_blocks')
            ->and($casts)->toHaveKey('sidebar_blocks')
            ->and($casts)->toHaveKey('footer_blocks')
            ->and($casts)->toHaveKey('middleware');
    });

    test('page model has translatable fields', function (): void {
        $page = new Page();

        expect($page->translatable)->toContain('title')
            ->and($page->translatable)->toContain('blocks')
            ->and($page->translatable)->toContain('content_blocks')
            ->and($page->translatable)->toContain('sidebar_blocks')
            ->and($page->translatable)->toContain('footer_blocks');
    });

    test('page model has getMiddlewareBySlug method', function (): void {
        expect(method_exists(Page::class, 'getMiddlewareBySlug'))->toBeTrue();
    });

    test('page model uses HasBlocks trait', function (): void {
        $page = new Page();

        expect(in_array('Modules\Cms\Models\Traits\HasBlocks', class_uses_recursive($page)))->toBeTrue();
    });

    test('page model uses SushiToJson trait', function (): void {
        $page = new Page();

        expect(in_array('Modules\Tenant\Models\Traits\SushiToJson', class_uses_recursive($page)))->toBeTrue();
    });

    test('page model has getRows method', function (): void {
        $page = new Page();

        expect(method_exists($page, 'getRows'))->toBeTrue();
    });
});
