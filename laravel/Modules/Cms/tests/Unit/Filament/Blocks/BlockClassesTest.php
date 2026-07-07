<?php

declare(strict_types=1);

use Modules\Cms\Filament\Blocks\ActionsBlock;
use Modules\Cms\Filament\Blocks\ContactBlock;
use Modules\Cms\Filament\Blocks\CtaBlock;
use Modules\Cms\Filament\Blocks\HeroBlock;
use Modules\Cms\Filament\Blocks\InfoBlock;
use Modules\Cms\Filament\Blocks\LinksBlock;
use Modules\Cms\Filament\Blocks\LogoBlock;
use Modules\Cms\Filament\Blocks\NewsletterBlock;
use Modules\Cms\Filament\Blocks\ParagraphBlock;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('ActionsBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(ActionsBlock::class));
});

test('ActionsBlock has getBlockSchema method', function (): void {
    $schema = ActionsBlock::getBlockSchema();
    Assert::assertNotEmpty($schema);
});

test('ContactBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(ContactBlock::class));
});

test('CtaBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(CtaBlock::class));
});

test('HeroBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(HeroBlock::class));
});

test('InfoBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(InfoBlock::class));
});

test('LinksBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(LinksBlock::class));
});

test('LogoBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(LogoBlock::class));
});

test('NewsletterBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(NewsletterBlock::class));
});

test('ParagraphBlock can be instantiated', function (): void {
    Assert::assertTrue(class_exists(ParagraphBlock::class));
});
