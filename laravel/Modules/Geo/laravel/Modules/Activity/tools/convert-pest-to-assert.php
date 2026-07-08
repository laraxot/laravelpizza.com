<?php

declare(strict_types=1);

use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\preg_match;
use function Safe\preg_replace;

/** @usage php Modules/Activity/tools/convert-pest-to-assert.php */
$root = dirname(__DIR__).'/tests';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));

foreach ($iterator as $file) {
    if (! $file instanceof SplFileInfo) {
        continue;
    }

    if (! $file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    if (str_ends_with($path, '/Pest.php') || str_ends_with($path, '/PestStubs.php')) {
        continue;
    }

    $code = (string) file_get_contents($path);
    if (! str_contains($code, 'expect(')) {
        continue;
    }

    $code = preg_replace('/\s*\/\/\s*@phpstan-ignore-(line|next-line)[^\n]*\n/', "\n", $code) ?? $code;

    if (! str_contains($code, 'use PHPUnit\\Framework\\Assert;')) {
        $matches = [];
        if (preg_match('/namespace\s+[^;]+;\s*\n((?:use\s+[^;]+;\s*\n)*)/', $code, $matches, PREG_OFFSET_CAPTURE) === 1
            && isset($matches[1]) && is_array($matches[1])) {
            $insertAt = $matches[1][1] + strlen($matches[1][0]);
            $code = substr($code, 0, $insertAt)."use PHPUnit\\Framework\\Assert;\n".substr($code, $insertAt);
        } else {
            $m = [];
            if (preg_match('/^(<\?php\s+declare\(strict_types=1\);\s*\n)/', $code, $m, PREG_OFFSET_CAPTURE) === 1
                && isset($m[1]) && is_array($m[1])) {
                $insertAt = $m[1][1] + strlen($m[1][0]);
                $code = substr($code, 0, $insertAt)."use PHPUnit\\Framework\\Assert;\n\n".substr($code, $insertAt);
            }
        }
    }

    // Solo assert su singola riga (no catene multilinea).
    $patterns = [
        '/^(\s*)expect\(([^;]+?)\)->not->toBeNull\(\);\s*$/m' => '$1Assert::assertNotNull($2);',
        '/^(\s*)expect\(([^;]+?)\)->toBeNull\(\);\s*$/m' => '$1Assert::assertNull($2);',
        '/^(\s*)expect\(([^;]+?)\)->toBeTrue\(\);\s*$/m' => '$1Assert::assertTrue($2);',
        '/^(\s*)expect\(([^;]+?)\)->toBeFalse\(\);\s*$/m' => '$1Assert::assertFalse($2);',
        '/^(\s*)expect\(([^;]+?)\)->toBeInstanceOf\(([^;]+?)\);\s*$/m' => '$1Assert::assertInstanceOf($3, $2);',
        '/^(\s*)expect\(([^;]+?)\)->toBe\(([^;]+?)\);\s*$/m' => '$1Assert::assertSame($3, $2);',
        '/^(\s*)expect\(([^;]+?)\)->toEqual\(([^;]+?)\);\s*$/m' => '$1Assert::assertEquals($3, $2);',
        '/^(\s*)expect\(([^;]+?)\)->toContain\(([^;]+?)\);\s*$/m' => '$1Assert::assertStringContainsString((string) $3, (string) $2);',
        '/^(\s*)expect\(([^;]+?)\)->toHaveCount\(([^;]+?)\);\s*$/m' => '$1Assert::assertCount($3, $2);',
        '/^(\s*)expect\(([^;]+?)\)->toMatchArray\(([^;]+?)\);\s*$/m' => '$1Assert::assertEquals($3, is_array($2) ? $2 : $2->all());',
        '/^(\s*)expect\(([^;]+?)\)->toBeGreaterThan\(([^;]+?)\);\s*$/m' => '$1Assert::assertGreaterThan($3, $2);',
        '/^(\s*)expect\(([^;]+?)\)->toBeString\(\);\s*$/m' => '$1Assert::assertIsString($2);',
        '/^(\s*)expect\(([^;]+?)\)->toBeEmpty\(\);\s*$/m' => '$1Assert::assertEmpty($2);',
        '/^(\s*)expect\(([^;]+?)\)->not->toBeEmpty\(\);\s*$/m' => '$1Assert::assertNotEmpty($2);',
        '/^(\s*)expect\(([^;]+?)\)->and\(([^)]+)\)->toBe\(([^)]+)\);\s*$/m' => '$1Assert::assertSame($4, $3);',
        '/^(\s*)expect\(([^;]+?)\)->and\(([^)]+)\)->toBeInstanceOf\(([^)]+)\);\s*$/m' => '$1Assert::assertInstanceOf($4, $3);',
    ];

    foreach ($patterns as $pattern => $replacement) {
        $code = preg_replace($pattern, $replacement, $code) ?? $code;
    }

    file_put_contents($path, $code);
}

echo "done\n";
