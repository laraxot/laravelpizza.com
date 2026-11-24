<?php

declare(strict_types=1);

use Modules\Cms\Models\Menu;
<<<<<<< HEAD
=======
use Modules\Cms\Tests\TestCase;
>>>>>>> laraxot/dev
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

<<<<<<< HEAD
=======
// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
test('Menu model can be instantiated', function () {
    Assert::assertSame(Menu::class, (new Menu)::class);

});

test('Menu model has expected fillable fields', function () {
    $menu = new Menu;

    $fillable = $menu->getFillable();

    Assert::assertContains('title', $fillable);

    Assert::assertContains('parent_id', $fillable);
});

test('Menu model implements HasRecursiveRelationships', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(HasRecursiveRelationships::class, $traits));
});

test('Menu model uses SushiToJsons trait', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(SushiToJsons::class, $traits));
});
