<?php

declare(strict_types=1);

use Modules\Cms\Models\Attachment;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('Attachment model can be instantiated', function () {
    $attachment = new Attachment;
    Assert::assertSame(Attachment::class, $attachment::class);

});

test('Attachment model has expected fillable fields', function () {
    $attachment = new Attachment;

    $fillable = $attachment->getFillable();

    Assert::assertContains('title', $fillable);

    Assert::assertContains('description', $fillable);

    Assert::assertContains('slug', $fillable);

    Assert::assertContains('disk', $fillable);

    Assert::assertContains('attachment', $fillable);
});

test('Attachment model has expected casts', function () {
    $attachment = new Attachment;

    $casts = $attachment->getCasts();

    Assert::assertArrayHasKey('attachment', $casts);

    Assert::assertSame('array', $casts['attachment']);
});

test('Attachment model implements HasMedia interface', function () {
    $attachment = new Attachment;
    Assert::assertSame(Attachment::class, $attachment::class);

});
