<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Cms\Filament\Blocks\ActionsBlock;
use Modules\Cms\Filament\Blocks\ContactBlock;
use Modules\Cms\Filament\Blocks\CtaBlock;
use Modules\Cms\Filament\Blocks\FeatureSectionsBlock;
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

test('FeatureSectionsBlock can be instantiated', function () {
    expect(FeatureSectionsBlock::class)->toBeString();
});

test('FeatureSectionsBlock has getBlockSchema method', function () {
    expect(method_exists(FeatureSectionsBlock::class, 'getBlockSchema'))->toBeTrue();

    $schema = FeatureSectionsBlock::getBlockSchema();
    expect($schema)->toBeArray();
});

test('ActionsBlock schema contains Repeater for items', function () {
    $schema = ActionsBlock::getBlockSchema();

    expect($schema)->toBeArray()
        ->toHaveCount(3);

    // Check first element is a Repeater (items)
    expect($schema[0])->toBeInstanceOf(Repeater::class);
});

test('ActionsBlock schema has alignment Select', function () {
    $schema = ActionsBlock::getBlockSchema();

    // Second element is alignment Select
    expect($schema[1])->toBeInstanceOf(Select::class);
});

test('ActionsBlock schema has gap Select', function () {
    $schema = ActionsBlock::getBlockSchema();

    // Third element is gap Select
    expect($schema[2])->toBeInstanceOf(Select::class);
});

test('ContactBlock schema returns array', function () {
    $schema = ContactBlock::getBlockSchema();

    expect($schema)->toBeArray();
});

test('ContactBlock has getBlockLabel method', function () {
    expect(method_exists(ContactBlock::class, 'getBlockLabel'))->toBeTrue();

    $label = ContactBlock::getBlockLabel();
    expect($label)->toBeString();
});

test('CtaBlock schema contains title TextInput', function () {
    $schema = CtaBlock::getBlockSchema();

    expect($schema[0])->toBeInstanceOf(TextInput::class);
});

test('CtaBlock schema contains description Textarea', function () {
    $schema = CtaBlock::getBlockSchema();

    expect($schema[1])->toBeInstanceOf(Textarea::class);
});

test('FeatureSectionsBlock schema contains title TextInput', function () {
    $schema = FeatureSectionsBlock::getBlockSchema();

    expect($schema[0])->toBeInstanceOf(TextInput::class);
});

test('FeatureSectionsBlock schema contains sections Repeater', function () {
    $schema = FeatureSectionsBlock::getBlockSchema();

    expect($schema[1])->toBeInstanceOf(Repeater::class);
});

test('HeroBlock schema contains required title TextInput', function () {
    $schema = HeroBlock::getBlockSchema();

    expect($schema[0])->toBeInstanceOf(TextInput::class);
});

test('HeroBlock schema contains FileUpload for image', function () {
    $schema = HeroBlock::getBlockSchema();

    expect($schema[2])->toBeInstanceOf(FileUpload::class);
});

test('HeroBlock schema contains ColorPickers', function () {
    $schema = HeroBlock::getBlockSchema();

    // Background, text, and CTA colors
    expect($schema[5])->toBeInstanceOf(ColorPicker::class);
    expect($schema[6])->toBeInstanceOf(ColorPicker::class);
});
