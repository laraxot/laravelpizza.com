<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\preg_match;
use function Safe\preg_match_all;

/*
 * I link Markdown del CLAUDE.md di root portano a file versionati che esistono.
 *
 * InstructionReferencesExistTest controlla i nomi tra backtick; i link `[testo](percorso)` restavano senza controllo.
 * bashscripts/ e' un repository a parte (laraxot/bashscripts_fila5), ignorato qui; docs/wiki/{rules,memories} sono link
 * simbolici verso di lui. Se bashscripts/ c'e', anche quei link devono esistere; se manca, si saltano (Insidie, CLAUDE.md).
 */
const AGENT_LINK_EXTERNAL_PREFIXES = ['docs/wiki/rules/', 'docs/wiki/memories/', 'bashscripts/'];

it('resolves every versioned link of the root CLAUDE.md', function (): void {
    $root = dirname(__DIR__, 6);
    $matches = [];
    preg_match_all('/\]\(([^)#\s]+)\)/', file_get_contents($root.'/CLAUDE.md'), $matches);

    $broken = [];
    foreach ($matches[1] as $link) {
        if (preg_match('#^[a-z]+://#', $link) === 1) {
            continue;
        }
        foreach (AGENT_LINK_EXTERNAL_PREFIXES as $prefix) {
            if (str_starts_with($link, $prefix) && ! is_dir($root.'/bashscripts')) {
                continue 2;
            }
        }
        if (! file_exists($root.'/'.$link)) {
            $broken[] = $link;
        }
    }

    Assert::assertSame([], $broken);
});
