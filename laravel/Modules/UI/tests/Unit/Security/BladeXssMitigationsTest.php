<?php

declare(strict_types=1);
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);
it('button blade renders semantic button or anchor tags', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/ui/button.blade.php';
    $contents = (string) file_get_contents($path);

    Assert::assertStringContainsString('$tagAttr', $contents);
    Assert::assertStringContainsString('cursor-pointer', $contents);
});

it('educational material detail renders structured content blocks', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/blocks/educational_material_detail.blade.php';

    $contents = (string) file_get_contents($path);

    Assert::assertStringContainsString('$material->title', $contents);
    Assert::assertStringContainsString('$material->type', $contents);
});

it('language controller validates locale against supported list', function (): void {
    $source = (string) file_get_contents(
        dirname(__DIR__, 3).'/app/Http/Controllers/LanguageController.php'
    );

    Assert::assertStringContainsString('supported_locales', $source);
    Assert::assertStringContainsString('in_array($locale, $supportedLocales', $source);
});
