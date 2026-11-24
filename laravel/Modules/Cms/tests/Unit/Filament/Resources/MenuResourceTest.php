<?php

declare(strict_types=1);

use Filament\Forms\Components\Field;
use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Cms\Filament\Resources\MenuResource\Schemas\MenuForm;
use Modules\Cms\Models\Menu;
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
describe('MenuResource', function (): void {
    test('menu resource has correct model', function (): void {
        $resource = new MenuResource;

        Assert::assertSame(Menu::class, $resource::getModel());
    });

    test('menu resource has form schema', function (): void {
        $schema = app(MenuForm::class)->getFormSchema();
        /* @var array<string, mixed> $schema */
        Assert::assertGreaterThan(0, count($schema));
    });

    test('menu resource has form fields', function (): void {
        $schema = app(MenuForm::class)->getFormSchema();

        // Check that form has required components
        $hasTitle = false;
        $hasItems = false;

        foreach ($schema as $item) {
            if (! $item instanceof Field) {
                continue;
            }
            $name = $item->getName();
            if ($name === 'title') {
                $hasTitle = true;
            }
            if ($name === 'items') {
                $hasItems = true;
            }
        }

        Assert::assertTrue($hasTitle);
        Assert::assertTrue($hasItems);
    });

    test('menu resource extends XotBaseResource', function (): void {
        Assert::assertTrue(class_exists(MenuResource::class));
    });
});
