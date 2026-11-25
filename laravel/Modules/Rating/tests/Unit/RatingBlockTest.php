<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Support\Facades\App;
use Modules\Rating\Enums\SupportedLocale;
use Modules\Rating\Filament\Blocks\Rating;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('create costruisce il blocco con il tipo canonico', function (): void {
    $block = Rating::create();

    Assert::assertSame(Rating::BLOCK_TYPE, $block->getName());
});

test('la label del blocco riporta il locale applicativo corrente', function (): void {
    // Nessun `App::setLocale()`: cambiare locale fa scrivere all'adapter Lang i file di
    // traduzione mancanti (`lang/en/` qui non esiste) — effetto collaterale su disco.
    $atteso = sprintf('Rating (%s)', SupportedLocale::fromString(App::getLocale())->getLabel());

    Assert::assertSame($atteso, Rating::create()->getLabel());
});

test('createFromFormData produce un RatingData', function (): void {
    $data = Rating::createFromFormData([
        'title' => 'Dal form',
        'position' => 2,
        'locale' => 'en',
    ]);

    Assert::assertSame('Dal form', $data->title);
    Assert::assertSame(2, $data->position);
    Assert::assertSame(SupportedLocale::EN, $data->locale);
});

test('createAdvanced accetta opzioni esplicite senza toccare il container', function (): void {
    $block = Rating::createAdvanced(options: ['vista-a' => 'Vista A', 'vista-b' => 'Vista B']);

    Assert::assertSame(Rating::BLOCK_TYPE, $block->getName());
});

test('createAdvanced accetta un nome personalizzato', function (): void {
    $block = Rating::createAdvanced(name: 'rating-custom', options: []);

    Assert::assertSame('rating-custom', $block->getName());
});
