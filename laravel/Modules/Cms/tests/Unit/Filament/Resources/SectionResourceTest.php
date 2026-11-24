<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Cms\Filament\Resources\SectionResource\Schemas\SectionForm;
use Modules\Cms\Models\Section;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
describe('SectionResource', function (): void {
    test('section resource has correct model', function (): void {
        $resource = new SectionResource;

        Assert::assertSame(Section::class, $resource::getModel());
    });

    test('section resource has form schema', function (): void {
        $schema = app(SectionForm::class)->getFormSchema();
        /* @var array<string, mixed> $schema */
        Assert::assertGreaterThan(0, count($schema));
    });

    test('section resource has form fields', function (): void {
        $schema = app(SectionForm::class)->getFormSchema();

        // Check that form has required components (check array keys)
        Assert::assertContains('info', array_keys($schema));
        Assert::assertContains('blocks', array_keys($schema));
    });

    test('section resource extends LangBaseResource', function (): void {
        Assert::assertTrue(class_exists(SectionResource::class));
    });
});
