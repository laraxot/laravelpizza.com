<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Filament;

use Illuminate\Support\Facades\Storage;
use Modules\Media\Filament\Infolists\VideoEntry;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * API fluente della entry video dell'infolist. Sono setter e getter con
 * normalizzazione dei tipi: nessuna query, nessuna richiesta di rete.
 * Ogni setter accetta anche una Closure, che il componente valuta al momento
 * della lettura: i test coprono entrambe le forme.
 */

uses(TestCase::class)->group('no-media-db');

test('every setter returns the same instance so the calls can be chained', function (): void {
    $entry = VideoEntry::make('video');

    Assert::assertSame($entry, $entry->disk('public'));
    Assert::assertSame($entry, $entry->height(200));
    Assert::assertSame($entry, $entry->width(300));
    Assert::assertSame($entry, $entry->circular());
    Assert::assertSame($entry, $entry->square());
    Assert::assertSame($entry, $entry->visibility('private'));
    Assert::assertSame($entry, $entry->stacked());
    Assert::assertSame($entry, $entry->overlap(4));
    Assert::assertSame($entry, $entry->ring(2));
    Assert::assertSame($entry, $entry->limit(5));
});

test('an integer size becomes pixels on both axes', function (): void {
    $entry = VideoEntry::make('video')->size(120);

    Assert::assertSame('120px', $entry->getWidth());
    Assert::assertSame('120px', $entry->getHeight());
});

test('a string size is kept verbatim', function (): void {
    $entry = VideoEntry::make('video')->size('50%');

    Assert::assertSame('50%', $entry->getWidth());
    Assert::assertSame('50%', $entry->getHeight());
});

test('unset dimensions read back as null', function (): void {
    $entry = VideoEntry::make('video');

    Assert::assertNull($entry->getWidth());
    Assert::assertNull($entry->getHeight());
});

test('dimensions accept a closure and evaluate it on read', function (): void {
    $entry = VideoEntry::make('video')
        ->width(fn (): int => 640)
        ->height(fn (): string => '360px');

    Assert::assertSame('640px', $entry->getWidth());
    Assert::assertSame('360px', $entry->getHeight());
});

test('the disk name falls back to the filament default when not set', function (): void {
    $entry = VideoEntry::make('video');

    Assert::assertSame(config('filament.default_filesystem_disk'), $entry->getDiskName());
});

test('an explicit disk wins and resolves to a real filesystem', function (): void {
    Storage::fake('video');
    $entry = VideoEntry::make('video')->disk('video');

    Assert::assertSame('video', $entry->getDiskName());
    Assert::assertSame(Storage::disk('video'), $entry->getDisk());
});

test('visibility defaults to public and can be overridden', function (): void {
    Assert::assertSame('public', VideoEntry::make('video')->getVisibility());
    Assert::assertSame('private', VideoEntry::make('video')->visibility('private')->getVisibility());
    Assert::assertSame('private', VideoEntry::make('video')->visibility(fn (): string => 'private')->getVisibility());
});

test('circular and square are false until asked for', function (): void {
    $entry = VideoEntry::make('video');

    Assert::assertFalse($entry->isCircular());
    Assert::assertFalse($entry->isSquare());

    Assert::assertTrue($entry->circular()->isCircular());
    Assert::assertTrue($entry->square()->isSquare());
    Assert::assertFalse($entry->circular(false)->isCircular());
});

test('extra image attributes round trip and reach the attribute bag', function (): void {
    $entry = VideoEntry::make('video')->extraImgAttributes(['class' => 'rounded', 'loading' => 'lazy']);

    Assert::assertSame(['class' => 'rounded', 'loading' => 'lazy'], $entry->getExtraImgAttributes());

    $bag = $entry->getExtraImgAttributeBag();
    Assert::assertSame('rounded', $bag->get('class'));
});

test('stacking, overlap, ring and limit read back what was set', function (): void {
    $entry = VideoEntry::make('video')->stacked()->overlap(3)->ring(2)->limit(7);

    Assert::assertTrue($entry->isStacked());
    Assert::assertSame(3, $entry->getOverlap());
    Assert::assertSame(2, $entry->getRing());
    Assert::assertSame(7, $entry->getLimit());
});

test('the default image url is null unless configured', function (): void {
    Assert::assertNull(VideoEntry::make('video')->getDefaultImageUrl());

    $entry = VideoEntry::make('video')->defaultImageUrl('https://cdn.example.test/placeholder.png');
    Assert::assertSame('https://cdn.example.test/placeholder.png', $entry->getDefaultImageUrl());
});
