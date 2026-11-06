<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Filament;

use Modules\Media\Filament\Tables\Columns\CloudFrontIconMediaColumn;
use Modules\Media\Filament\Tables\Columns\IconMediaColumn;
use Modules\Media\Tests\Fixtures\MediaColumnFileStub;
use Modules\Media\Tests\Fixtures\MediaColumnPlainRecordStub;
use Modules\Media\Tests\Fixtures\MediaColumnRecordStub;
use Modules\Media\Tests\TestCase;
use Modules\Xot\Filament\Tables\Columns\XotBaseIconColumn;
use PHPUnit\Framework\Assert;

/*
 * Le due colonne icona degli allegati. `setUp()` di Filament registra closure per
 * default/color/tooltip: qui si verificano su record finti, senza toccare il
 * database - un record che non espone `getFirstMedia()` deve degradare, non
 * esplodere.
 *
 * NB (ridondanza): IconMediaColumn e CloudFrontIconMediaColumn condividono
 * l'intero `setUp()` tranne l'azione finale. Segnalato su
 * laraxot/module_media_fila5#12; qui i due comportamenti sono fissati in modo
 * che una futura estrazione della base comune sia verificabile.
 *
 * I doppi sono classi nominate e non anonime: PDepend, e quindi PHPMD, non sa
 * visitare una classe anonima dichiarata dentro una funzione ed esce in errore.
 */

uses(TestCase::class)->group('no-media-db');

function mediaColumnRecordWith(?object $media): MediaColumnRecordStub
{
    $record = new MediaColumnRecordStub;
    $record->fakeMedia = $media;

    return $record;
}

test('both columns extend the shared xot base icon column', function (): void {
    Assert::assertInstanceOf(XotBaseIconColumn::class, IconMediaColumn::make('allegato'));
    Assert::assertInstanceOf(XotBaseIconColumn::class, CloudFrontIconMediaColumn::make('allegato'));
});

test('the column keeps the attachment name it was built with', function (): void {
    Assert::assertSame('fattura', IconMediaColumn::make('fattura')->getName());
    Assert::assertSame('fattura', CloudFrontIconMediaColumn::make('fattura')->getName());
});

test('a present attachment is green, a missing one is red', function (): void {
    $media = new MediaColumnFileStub('fattura.pdf');

    foreach ([IconMediaColumn::class, CloudFrontIconMediaColumn::class] as $class) {
        $withMedia = $class::make('fattura')->record(mediaColumnRecordWith($media));
        $withoutMedia = $class::make('fattura')->record(mediaColumnRecordWith(null));

        Assert::assertSame('success', $withMedia->getColor(null), $class);
        Assert::assertSame('danger', $withoutMedia->getColor(null), $class);
    }
});

test('a record without media capabilities degrades to red instead of failing', function (): void {
    foreach ([IconMediaColumn::class, CloudFrontIconMediaColumn::class] as $class) {
        Assert::assertSame(
            'danger',
            $class::make('fattura')->record(new MediaColumnPlainRecordStub)->getColor(null),
            $class,
        );
    }
});

test('the tooltip shows the file name, or says the document is missing', function (): void {
    $media = new MediaColumnFileStub('contratto.pdf');

    foreach ([IconMediaColumn::class, CloudFrontIconMediaColumn::class] as $class) {
        Assert::assertSame(
            'contratto.pdf',
            $class::make('fattura')->record(mediaColumnRecordWith($media))->getTooltip(),
            $class,
        );
        Assert::assertSame(
            'Documento non caricato',
            $class::make('fattura')->record(mediaColumnRecordWith(null))->getTooltip(),
            $class,
        );
    }
});
