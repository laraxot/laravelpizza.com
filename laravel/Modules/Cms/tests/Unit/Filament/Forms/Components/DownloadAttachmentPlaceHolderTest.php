<?php

declare(strict_types=1);

use Modules\Cms\Filament\Forms\Components\DownloadAttachmentPlaceHolder;
<<<<<<< HEAD
use Modules\Xot\Filament\Forms\Components\XotBaseTextEntry;
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use Modules\Xot\Filament\Forms\Components\XotBaseTextEntry;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
test('DownloadAttachmentPlaceHolder extends XotBaseTextEntry', function () {
    // `class_exists()` su una classe importata e' deciso staticamente: cio' che il test
    // verifica e' la classe base, cambiata quando `Placeholder` e' stata deprecata.
    Assert::assertTrue(
        (new ReflectionClass(DownloadAttachmentPlaceHolder::class))->isSubclassOf(XotBaseTextEntry::class),
    );
});

test('DownloadAttachmentPlaceHolder has setUp method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('DownloadAttachmentPlaceHolder has generateContent method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
