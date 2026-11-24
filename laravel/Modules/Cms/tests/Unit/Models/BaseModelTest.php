<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModel;
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
function createCmsBaseModelTestDouble(): BaseModel
{
    return new class extends BaseModel
    {
        protected $table = 'test_cms_table';
    };
}

test('base model extends eloquent model', function (): void {
    $baseModel = createCmsBaseModelTestDouble();

    Assert::assertFalse($baseModel->exists);
});

test('base model has correct table name', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertSame('test_cms_table', $baseModel->getTable());
});

test('base model can be instantiated', function (): void {
    $baseModel = createCmsBaseModelTestDouble();

    Assert::assertSame('test_cms_table', $baseModel->getTable());
});

test('base model has proper inheritance chain', function (): void {
    $baseModel = createCmsBaseModelTestDouble();

    Assert::assertTrue(is_subclass_of($baseModel, BaseModel::class));
});

test('base model has timestamps enabled', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertTrue($baseModel->usesTimestamps());
});
