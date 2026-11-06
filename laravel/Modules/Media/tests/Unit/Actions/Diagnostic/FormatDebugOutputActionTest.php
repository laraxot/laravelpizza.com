<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions\Diagnostic;

use Modules\Media\Actions\Diagnostic\S3\FormatDebugOutputAction;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Formattazione del report diagnostico S3: e' pura manipolazione di stringhe,
 * non tocca ne' rete ne' database.
 */

uses(TestCase::class)->group('no-media-db');

test('empty results fall back to the given message', function (): void {
    $output = (new FormatDebugOutputAction)->execute([], 'nessun risultato');

    Assert::assertSame('nessun risultato', $output);
});

test('a well formed result renders title, status and data lines', function (): void {
    $output = (new FormatDebugOutputAction)->execute([
        'bucket' => [
            'title' => 'Bucket',
            'status' => 'ok',
            'data' => [
                'region' => 'eu-west-1',
                'objects' => 12,
            ],
        ],
    ], 'nessun risultato');

    $lines = explode("\n", $output);

    Assert::assertSame('=== Bucket ===', $lines[0]);
    Assert::assertSame('Status: ok', $lines[1]);
    Assert::assertSame('', $lines[2]);
    Assert::assertSame('region: eu-west-1', $lines[3]);
    Assert::assertSame('objects: 12', $lines[4]);
    Assert::assertSame(str_repeat('-', 50), $lines[6]);
});

test('nested array values are rendered as pretty printed json', function (): void {
    $output = (new FormatDebugOutputAction)->execute([
        'policy' => [
            'title' => 'Policy',
            'status' => 'ko',
            'data' => ['statements' => ['Allow', 'Deny']],
        ],
    ], 'nessun risultato');

    Assert::assertStringContainsString('statements: [', $output);
    Assert::assertStringContainsString('"Allow"', $output);
    Assert::assertStringContainsString('"Deny"', $output);
});

test('entries that are not arrays or lack the required keys are skipped', function (): void {
    $output = (new FormatDebugOutputAction)->execute([
        'scalare' => 'non e un array',
        'incompleto' => ['title' => 'Solo il titolo'],
    ], 'nessun risultato');

    Assert::assertSame('', $output);
});

test('several results are separated by their own rule line', function (): void {
    $result = static fn (string $title): array => [
        'title' => $title,
        'status' => 'ok',
        'data' => ['k' => 'v'],
    ];

    $output = (new FormatDebugOutputAction)->execute([
        'primo' => $result('Primo'),
        'secondo' => $result('Secondo'),
    ], 'nessun risultato');

    Assert::assertSame(2, substr_count($output, str_repeat('-', 50)));
    Assert::assertStringContainsString('=== Primo ===', $output);
    Assert::assertStringContainsString('=== Secondo ===', $output);
});
