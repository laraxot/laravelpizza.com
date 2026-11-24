<?php

declare(strict_types=1);

use Modules\Cms\Models\PageContent;
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
test('PageContent model can be instantiated', function () {
    $pageContent = new PageContent;
    Assert::assertSame(PageContent::class, $pageContent::class);

});

test('PageContent model has expected fillable fields', function () {
    $pageContent = new PageContent;

    $fillable = $pageContent->getFillable();

    Assert::assertContains('name', $fillable);

    Assert::assertContains('slug', $fillable);

    Assert::assertContains('blocks', $fillable);
});

test('PageContent model extends BaseModel', function () {
    $pageContent = new PageContent;
    Assert::assertSame(PageContent::class, $pageContent::class);

});

test('PageContent model has translatable fields', function () {
    $pageContent = new PageContent;

    Assert::assertContains('name', $pageContent->translatable);
    Assert::assertContains('blocks', $pageContent->translatable);
});
