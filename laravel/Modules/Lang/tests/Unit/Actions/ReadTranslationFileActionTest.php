<?php

declare(strict_types=1);

use Modules\Lang\Actions\ReadTranslationFileAction;

beforeEach(function () {
    $this->action = new ReadTranslationFileAction;
    $this->testFilePath = storage_path('test_translations.php');
    $this->testTranslations = [
        'auth' => [
            'failed' => 'These credentials do not match our records.',
            'password' => 'The provided password is incorrect.',
        ],
        'pagination' => [
            'previous' => '&laquo; Previous',
            'next' => 'Next &raquo;',
        ],
    ];
});

afterEach(function () {
    cleanupTranslationFile($this->testFilePath);
});

describe('ReadTranslationFileAction Business Logic', function () {
    test('can read valid translation file', function () {
        createTranslationFile($this->testFilePath, $this->testTranslations);

        $result = $this->action->execute($this->testFilePath);

        expect($result)->toBeArray();
        expect($result)->toHaveKey('auth');
        expect($result)->toHaveKey('pagination');
        expect($result['auth']['failed'])->toBe('These credentials do not match our records.');
    });

    test('throws exception for non-existent file', function () {
        $nonExistentFile = storage_path('non_existent.php');

        $this->action->execute($nonExistentFile);
    })->throws(Exception::class, 'File di traduzione non trovato:');

    test('throws exception for unreadable file', function () {
        createTranslationFile($this->testFilePath, $this->testTranslations);
        chmod($this->testFilePath, 0o000);

        $this->action->execute($this->testFilePath);
    })->throws(Exception::class, 'File di traduzione non leggibile:');

    test('throws exception for invalid file content', function () {
        file_put_contents($this->testFilePath, '<?php return "invalid content";');

        $this->action->execute($this->testFilePath);
    })->throws(Exception::class, 'File di traduzione non valido:');

    test('converts array to php format correctly', function () {
        $translations = [
            'simple_key' => 'Simple value',
            'nested' => [
                'key1' => 'Value 1',
                'key2' => 'Value 2',
            ],
        ];

        $phpContent = $this->action->toPhp($translations);

        expect($phpContent)->toContain("<?php\n\nreturn [");
        expect($phpContent)->toContain("'simple_key' => 'Simple value'");
        expect($phpContent)->toContain("'nested' => [");
        expect($phpContent)->toContain("'key1' => 'Value 1'");
        expect($phpContent)->toContain("];\n");
    });

    test('handles special characters in translations', function () {
        $translations = [
            'quotes' => "Text with 'single' and \"double\" quotes",
            'backslashes' => 'Text with \\ backslashes',
            'newlines' => "Text with\nnewlines",
        ];

        $phpContent = $this->action->toPhp($translations);

        expect($phpContent)->toContain("Text with \\'single\\' and \\\"double\\\" quotes");
        expect($phpContent)->toContain('Text with \\\\ backslashes');
        expect($phpContent)->toContain('Text with\\nnewlines');
    });

    test('handles deeply nested arrays', function () {
        $translations = [
            'level1' => [
                'level2' => [
                    'level3' => [
                        'deep_key' => 'Deep value',
                    ],
                ],
            ],
        ];

        $phpContent = $this->action->toPhp($translations);

        expect($phpContent)->toContain("'level1' => [");
        expect($phpContent)->toContain("'level2' => [");
        expect($phpContent)->toContain("'level3' => [");
        expect($phpContent)->toContain("'deep_key' => 'Deep value'");
    });

    test('generates proper indentation for nested arrays', function () {
        $translations = [
            'parent' => [
                'child' => 'value',
            ],
        ];

        $phpContent = $this->action->toPhp($translations);
        $lines = explode("\n", $phpContent);

        // Find the parent line and check indentation
        $parentLine = array_filter($lines, fn ($line) => str_contains($line, "'parent'"));
        $childLine = array_filter($lines, fn ($line) => str_contains($line, "'child'"));

        expect(current($parentLine))->toStartWith('    ');
        expect(current($childLine))->toStartWith('        ');
    });

    test('handles empty arrays', function () {
        $translations = [
            'empty_array' => [],
            'normal_key' => 'normal_value',
        ];

        $phpContent = $this->action->toPhp($translations);

        expect($phpContent)->toContain("'empty_array' => [");
        expect($phpContent)->toContain("'normal_key' => 'normal_value'");
    });

    test('handles numeric values in translations', function () {
        $translations = [
            'number' => 123,
            'float' => 45.67,
            'boolean_true' => true,
            'boolean_false' => false,
        ];

        $phpContent = $this->action->toPhp($translations);

        expect($phpContent)->toContain("'number' => '123'");
        expect($phpContent)->toContain("'float' => '45.67'");
        expect($phpContent)->toContain("'boolean_true' => '1'");
        expect($phpContent)->toContain("'boolean_false' => ''");
    });

    test('preserves key order in output', function () {
        $translations = [
            'z_last' => 'Last value',
            'a_first' => 'First value',
            'm_middle' => 'Middle value',
        ];

        $phpContent = $this->action->toPhp($translations);
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

        expect($zPos)->toBeLessThan($aPos);
        expect($aPos)->toBeLessThan($mPos);
    });
});
