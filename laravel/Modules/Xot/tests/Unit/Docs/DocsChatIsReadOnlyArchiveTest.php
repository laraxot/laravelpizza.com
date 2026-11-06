<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use function Safe\glob;

uses(\Modules\Xot\Tests\TestCase::class);

/**
 * `docs/chat/` e' un archivio in sola lettura.
 *
 * Il 2026-10-27 l'utente ha deciso: «quello che facevamo con la cartella docs/chat/ ora lo
 * facciamo con le bmad stories». Presa in carico, progressi, discussione fra agenti e handoff
 * si scrivono nella story BMAD del modulo o tema owner. Le cartelle `docs/chat/` restano
 * come cronologia: non si cancellano, ma non crescono piu'.
 *
 * Il tetto per cartella e' il numero di file `.md` misurato quel giorno e puo' solo scendere.
 * Una cartella `docs/chat/` nuova in un modulo o tema fa fallire il test.
 *
 * Legge solo il filesystem: niente `TestCase` e niente database, cosi' gira anche dove il DB
 * di test non e' raggiungibile.
 *
 * @see docs/wiki/rules/agent-chat-directory.md
 */

/**
 * Tetto di file `.md` per cartella, misurato il 2026-10-27. Percorsi relativi alla radice del repo.
 *
 * @var array<string, int>
 */
const DOCS_CHAT_MARKDOWN_CEILING = [
    'docs/chat' => 338,
    'laravel/Modules/Comment/docs/chat' => 1,
    'laravel/Modules/Geo/docs/chat' => 68,
    'laravel/Modules/Rating/docs/chat' => 4,
];

/**
 * @return array<string, int> cartella docs/chat (relativa alla radice del repo) => file `.md` contenuti
 */
function docsChatMarkdownCounts(): array
{
    $laravelRoot = dirname(__DIR__, 5); // Modules/Xot/tests/Unit/Docs -> laravel
    $repoRoot = dirname($laravelRoot);

    /** @var list<string> $moduleDirs */
    $moduleDirs = glob($laravelRoot.'/Modules/*/docs/chat', GLOB_ONLYDIR);
    /** @var list<string> $themeDirs */
    $themeDirs = glob($laravelRoot.'/Themes/*/docs/chat', GLOB_ONLYDIR);

    $dirs = array_merge([$repoRoot.'/docs/chat'], $moduleDirs, $themeDirs);
    $counts = [];

    foreach ($dirs as $dir) {
        if (! is_dir($dir)) {
            continue;
        }

        $count = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $fileInfo) {
            if ($fileInfo instanceof \SplFileInfo && $fileInfo->isFile() && str_ends_with($fileInfo->getFilename(), '.md')) {
                $count++;
            }
        }

        $counts[str_replace($repoRoot.'/', '', $dir)] = $count;
    }

    ksort($counts);

    return $counts;
}

test('nessuna cartella docs/chat nuova in moduli o temi', function (): void {
    $unexpected = array_diff(array_keys(docsChatMarkdownCounts()), array_keys(DOCS_CHAT_MARKDOWN_CEILING));

    expect($unexpected)->toBeEmpty(
        "Cartella docs/chat nuova: il coordinamento fra agenti si scrive nella story BMAD del modulo owner\n"
        .'(docs/stories/*.story.md), vedi docs/wiki/rules/agent-chat-directory.md. Cartelle: '
        .implode(', ', $unexpected)
    );
});

test('nessun file nuovo nelle cartelle docs/chat', function (): void {
    $grown = [];

    foreach (docsChatMarkdownCounts() as $dir => $count) {
        $ceiling = DOCS_CHAT_MARKDOWN_CEILING[$dir] ?? 0;

        if ($count > $ceiling) {
            $grown[] = "{$dir}: {$count} file, tetto {$ceiling}";
        }
    }

    expect($grown)->toBeEmpty(
        "docs/chat e' un archivio in sola lettura dal 2026-10-27.\n"
        ."Scrivi presa in carico, aggiornamenti, discussione fra agenti e handoff nella story BMAD owner.\n"
        .implode("\n", $grown)
    );
});

test('il tetto resta allineato, cosi la guardia continua a misurare', function (): void {
    $counts = docsChatMarkdownCounts();

    foreach (DOCS_CHAT_MARKDOWN_CEILING as $dir => $ceiling) {
        expect($counts[$dir] ?? 0)->toBeGreaterThan(
            $ceiling - 10,
            "In {$dir} mancano piu' di 10 file: abbassa DOCS_CHAT_MARKDOWN_CEILING['{$dir}'] "
            .'al numero attuale ('.($counts[$dir] ?? 0).').'
        );
    }
});
