<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

use Modules\Lang\Actions\ReadTranslationFileAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\chmod;
use function Safe\file_put_contents;
use function Safe\unlink;

uses(TestCase::class);

/**
 * @return array<string, mixed>
 */
function defaultReadTranslationTestData(): array
{
    return [
        'auth' => [
            'failed' => 'These credentials do not match our records.',
            'password' => 'The provided password is incorrect.',
        ],
        'pagination' => [
            'previous' => '&laquo; Previous',
            'next' => 'Next &raquo;',
        ],
    ];
}

function readTranslationTestFilePath(): string
{
    return sys_get_temp_dir().'/test_translations.php';
}

function makeReadTranslationFileAction(): ReadTranslationFileAction
{
    return new ReadTranslationFileAction();
}

afterEach(function (): void {
    $path = readTranslationTestFilePath();
    if (file_exists($path)) {
        unlink($path);
    }
});

describe('Read Translation File Action', function (): void {
    test('can read valid translation file', function (): void {
        /** @var TestCase $this */
        $filePath = readTranslationTestFilePath();
        $translations = defaultReadTranslationTestData();
        createTranslationFile($filePath, $translations);

        $result = makeReadTranslationFileAction()->execute($filePath);

        Assert::assertArrayHasKey('auth', $result);
        Assert::assertArrayHasKey('pagination', $result);
        Assert::assertIsArray($result['auth']);
        Assert::assertSame('These credentials do not match our records.', $result['auth']['failed']);
    });

    test('throws exception for non existent file', function (): void {
        /* @var TestCase $this */
        $this->expectApplicationException(\Exception::class, 'File di traduzione non trovato:');

        makeReadTranslationFileAction()->execute(storage_path('non_existent.php'));
    });

    test('throws exception for unreadable file', function (): void {
        /** @var TestCase $this */
        $filePath = readTranslationTestFilePath();
        createTranslationFile($filePath, defaultReadTranslationTestData());
        chmod($filePath, 0o000);

        $this->expectApplicationException(\Exception::class, 'File di traduzione non leggibile:');

        makeReadTranslationFileAction()->execute($filePath);
    });

    test('throws exception for invalid file content', function (): void {
        /** @var TestCase $this */
        $filePath = readTranslationTestFilePath();
        file_put_contents($filePath, ' return "invalid content";');

        $this->expectApplicationException(\Exception::class, 'File di traduzione non valido:');

        makeReadTranslationFileAction()->execute($filePath);
    });

    test('converts array to php format correctly', function (): void {
        $action = makeReadTranslationFileAction();
        $translations = [
            'simple_key' => 'Simple value',
            'nested' => [
                'key1' => 'Value 1',
                'key2' => 'Value 2',
            ],
        ];

        $phpContent = $action->toPhp($translations);

        Assert::assertStringContainsString("\n\nreturn [", $phpContent);
        Assert::assertStringContainsString("'simple_key' => 'Simple value'", $phpContent);
        Assert::assertStringContainsString("'nested' => [", $phpContent);
        Assert::assertStringContainsString("'key1' => 'Value 1'", $phpContent);
        Assert::assertStringContainsString("];\n", $phpContent);
    });

    test('handles special characters in translations', function (): void {
        $action = makeReadTranslationFileAction();
        $translations = [
            'quotes' => "Text with 'single' and \"double\" quotes",
            'backslashes' => 'Text with \\ backslashes',
            'newlines' => "Text with\nnewlines",
        ];

        $phpContent = $action->toPhp($translations);

        Assert::assertStringContainsString("Text with \\'single\\' and \\\"double\\\" quotes", $phpContent);
        Assert::assertStringContainsString('Text with \\\\ backslashes', $phpContent);
        Assert::assertStringContainsString("Text with\nnewlines", $phpContent);
    });

    test('handles deeply nested arrays', function (): void {
        $action = makeReadTranslationFileAction();
        $translations = [
            'level1' => [
                'level2' => [
                    'level3' => [
                        'deep_key' => 'Deep value',
                    ],
                ],
            ],
        ];

        $phpContent = $action->toPhp($translations);

        Assert::assertStringContainsString("'level1' => [", $phpContent);
        Assert::assertStringContainsString("'level2' => [", $phpContent);
        Assert::assertStringContainsString("'level3' => [", $phpContent);
        Assert::assertStringContainsString("'deep_key' => 'Deep value'", $phpContent);
    });

    test('generates proper indentation for nested arrays', function (): void {
        $action = makeReadTranslationFileAction();
        $translations = [
            'parent' => [
                'child' => 'value',
            ],
        ];

        $phpContent = $action->toPhp($translations);
        $lines = explode("\n", $phpContent);

        $parentLine = array_filter($lines, fn ($line) => str_contains($line, "'parent'"));
        $childLine = array_filter($lines, fn ($line) => str_contains($line, "'child'"));

        Assert::assertStringStartsWith('    ', (string) current($parentLine));
        Assert::assertStringStartsWith('        ', (string) current($childLine));
    });

    test('handles empty arrays', function (): void {
        $action = makeReadTranslationFileAction();
        $translations = [
            'empty_array' => [],
            'normal_key' => 'normal_value',
        ];

        $phpContent = $action->toPhp($translations);

        Assert::assertStringContainsString("'empty_array' => [", $phpContent);
        Assert::assertStringContainsString("'normal_key' => 'normal_value'", $phpContent);
    });

    test('handles numeric values in translations', function (): void {
        $action = makeReadTranslationFileAction();
        $translations = [
            'number' => 123,
            'float' => 45.67,
            'boolean_true' => true,
            'boolean_false' => false,
        ];

        $phpContent = $action->toPhp($translations);

        Assert::assertStringContainsString("'number' => '123'", $phpContent);
        Assert::assertStringContainsString("'float' => '45.67'", $phpContent);
        Assert::assertStringContainsString("'boolean_true' => '1'", $phpContent);
        Assert::assertStringContainsString("'boolean_false' => ''", $phpContent);
    });

    test('preserves key order in output', function (): void {
        $action = makeReadTranslationFileAction();
        $translations = [
            'z_last' => 'Last value',
            'a_first' => 'First value',
            'm_middle' => 'Middle value',
        ];

        $phpContent = $action->toPhp($translations);
        $lines = explode("\n", $phpContent);

        $zPos = -1;
        $aPos = -1;
        $mPos = -1;

        foreach ($lines as $index => $line) {
            if (str_contains($line, "'z_last'")) {
                $zPos = $index;
            }
            if (str_contains($line, "'a_first'")) {
                $aPos = $index;
            }
            if (str_contains($line, "'m_middle'")) {
                $mPos = $index;
            }
        }

        Assert::assertLessThan($aPos, $zPos);
        Assert::assertLessThan($mPos, $aPos);
    });
});
