<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Filament\Resources\PageResource\Schemas\PageForm;
use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

describe('PageResource', function (): void {
    test('page resource has correct model', function (): void {
        $resource = new PageResource;

        Assert::assertSame(Page::class, $resource::getModel());
    });

    test('page resource has form schema', function (): void {
        $schema = app(PageForm::class)->getFormSchema();
        /* @var array<string, mixed> $schema */
        Assert::assertGreaterThan(0, count($schema));
    });

    test('page resource has form fields', function (): void {
        $schema = app(PageForm::class)->getFormSchema();

        // Check that form has required components (check array keys)
        Assert::assertContains('title', array_keys($schema));
        Assert::assertContains('slug', array_keys($schema));
        Assert::assertContains('content', array_keys($schema));
    });

    test('page resource extends LangBaseResource', function (): void {
        Assert::assertTrue(class_exists(PageResource::class));
    });
});
