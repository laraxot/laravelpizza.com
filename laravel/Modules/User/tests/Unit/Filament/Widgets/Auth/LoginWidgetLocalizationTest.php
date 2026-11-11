<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use function Safe\file_get_contents;

uses(TestCase::class);

/**
 * Regressione D37: il redirect post-login non deve chiamare
 * getLocalizedURL() con un path come primo argomento (firma locale-first).
 */
test('login widget source uses localizeURL with explicit locale second', function (): void {
    $source = (string) file_get_contents(
        dirname(__DIR__, 5).'/app/Filament/Widgets/Auth/LoginWidget.php'
    );

    expect($source)
        ->toContain('LaravelLocalization::localizeURL(')
        ->not->toContain("getLocalizedURL('/' .")
        ->not->toContain('getLocalizedURL(route(')
        ->toContain('getSupportedLanguagesKeys()');
});
