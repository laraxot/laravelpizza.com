<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Filament\Blocks\ActionsBlock;
use Modules\Cms\Filament\Blocks\ContactBlock;
use Modules\Cms\Filament\Blocks\CtaBlock;
use Modules\Cms\Filament\Blocks\HeroBlock;
use Modules\Cms\Filament\Blocks\InfoBlock;
use Modules\Cms\Filament\Blocks\LinksBlock;
use Modules\Cms\Filament\Blocks\LogoBlock;
use Modules\Cms\Filament\Blocks\NewsletterBlock;
use Modules\Cms\Filament\Blocks\ParagraphBlock;

test('ActionsBlock can be instantiated', function () {
    expect(ActionsBlock::class)->toBeString();
});

test('ActionsBlock has getBlockSchema method', function () {
    expect(method_exists(ActionsBlock::class, 'getBlockSchema'))->toBeTrue();

    $schema = ActionsBlock::getBlockSchema();
    expect($schema)->toBeArray();
});

test('ContactBlock can be instantiated', function () {
    expect(ContactBlock::class)->toBeString();
});

test('CtaBlock can be instantiated', function () {
    expect(CtaBlock::class)->toBeString();
});

test('HeroBlock can be instantiated', function () {
    expect(HeroBlock::class)->toBeString();
});

test('InfoBlock can be instantiated', function () {
    expect(InfoBlock::class)->toBeString();
});

test('LinksBlock can be instantiated', function () {
    expect(LinksBlock::class)->toBeString();
});

test('LogoBlock can be instantiated', function () {
    expect(LogoBlock::class)->toBeString();
});

test('NewsletterBlock can be instantiated', function () {
    expect(NewsletterBlock::class)->toBeString();
});

test('ParagraphBlock can be instantiated', function () {
    expect(ParagraphBlock::class)->toBeString();
});
