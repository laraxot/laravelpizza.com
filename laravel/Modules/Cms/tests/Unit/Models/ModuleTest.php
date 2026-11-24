<?php

declare(strict_types=1);

use Modules\Cms\Models\Module;
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
test('Module model can be instantiated', function () {
    $module = new Module;
    Assert::assertSame(Module::class, $module::class);

});

test('Module model has expected fillable fields', function () {
    $module = new Module;

    $fillable = $module->getFillable();

    Assert::assertContains('id', $fillable);

    Assert::assertContains('name', $fillable);
});

test('Module model extends BaseModel', function () {
    $module = new Module;
    Assert::assertSame(Module::class, $module::class);

});

test('Module model uses Sushi trait', function () {
    $reflection = new ReflectionClass(Module::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(Sushi\Sushi::class, $traits));
});

test('Module model has id as route key', function () {
    $module = new Module;

    Assert::assertSame('id', $module->getRouteKeyName());
});
