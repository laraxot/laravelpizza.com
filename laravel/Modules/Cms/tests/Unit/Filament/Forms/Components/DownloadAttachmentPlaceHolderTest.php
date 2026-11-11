<?php

declare(strict_types=1);

use Modules\Cms\Filament\Forms\Components\DownloadAttachmentPlaceHolder;
use Modules\Xot\Filament\Forms\Components\XotBaseTextEntry;
use PHPUnit\Framework\Assert;

test('DownloadAttachmentPlaceHolder extends XotBaseTextEntry', function () {
    // `class_exists()` su una classe importata e' deciso staticamente: cio' che il test
    // verifica e' la classe base, cambiata quando `Placeholder` e' stata deprecata.
    Assert::assertTrue(
        (new ReflectionClass(DownloadAttachmentPlaceHolder::class))->isSubclassOf(XotBaseTextEntry::class),
    );
});

test('DownloadAttachmentPlaceHolder has setUp method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('DownloadAttachmentPlaceHolder has generateContent method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
