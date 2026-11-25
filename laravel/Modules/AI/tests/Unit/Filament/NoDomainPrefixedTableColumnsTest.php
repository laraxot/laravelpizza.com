<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;

use function Safe\file_get_contents;

/*
 * Vietato inventare get{Domain}TableColumns al posto del contratto getTableColumns.
 * Allowlist: getTableColumns, getGridTableColumns (layout HasXotTable).
 *
 * @see laravel/Modules/Ptv/docs/adr/0005-gettablecolumns-not-domain-prefix.md
 */

/**
 * @return list<string> "path:line:snippet"
 */
function domainPrefixedTableColumnHooks(): array
{
    $modulesRoot = dirname(__DIR__, 4);
    $offenders = [];

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($modulesRoot, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    /** @var RegexIterator<SplFileInfo> $phpFiles */
    $phpFiles = new RegexIterator($iterator, '/\.php$/');

    foreach ($phpFiles as $fileInfo) {
        if (! $fileInfo instanceof SplFileInfo || ! $fileInfo->isFile()) {
            continue;
        }

        $path = $fileInfo->getPathname();
        if (str_contains($path, DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR)) {
            continue;
        }
        if (str_contains($path, DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR)) {
            continue;
        }

        $contents = file_get_contents($path);
        if (! preg_match_all(
            '/^([ \t]*(?:public|protected|private|final|abstract|static|\s)*function\s+get(?!TableColumns\b|GridTableColumns\b)(\w+)TableColumns\s*\()/m',
            $contents,
            $matches,
            PREG_OFFSET_CAPTURE
        )) {
            continue;
        }

        foreach ($matches[0] as $match) {
            $snippet = trim($match[0]);
            $offset = $match[1];
            $line = substr_count(substr($contents, 0, $offset), "\n") + 1;
            $offenders[] = $path.':'.$line.':'.$snippet;
        }
    }

    sort($offenders);

    return $offenders;
}

test('no domain-prefixed getXxxTableColumns hooks in Modules PHP', function (): void {
    expect(domainPrefixedTableColumnHooks())->toBe([]);
});
