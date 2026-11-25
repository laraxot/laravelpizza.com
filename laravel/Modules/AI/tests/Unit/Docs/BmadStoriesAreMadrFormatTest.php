<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use Symfony\Component\Finder\Finder;

use function Safe\glob;
use function Safe\preg_match;

/*
 * Ogni BMAD story usa lo scheletro MADR harness (come gli ADR)
 * e basename NNNN-titolo-con-trattini.story.md (ADR Xot 0040).
 * Template: Modules/Xot/docs/bmad/stories/0000-template.story.md
 */

/**
 * @return list<string>
 */
function bmadSafeGlobDirs(string $pattern): array
{
    $dirs = [];
    foreach (glob($pattern, GLOB_ONLYDIR) as $match) {
        if (is_string($match) && is_dir($match)) {
            $dirs[] = $match;
        }
    }

    return $dirs;
}

/**
 * Canon story dirs under Modules/Themes (MADR body + basename).
 *
 * @return list<string>
 */
function bmadModuleThemeStoryDirectories(): array
{
    $moduleRoot = dirname(__DIR__, 4);
    $themesRoot = dirname(__DIR__, 5).'/Themes';

    $dirs = [];

    foreach ([$moduleRoot, $themesRoot] as $root) {
        if (! is_dir($root)) {
            continue;
        }

        $dirs = array_merge(
            $dirs,
            bmadSafeGlobDirs($root.'/*/docs/bmad/stories'),
            bmadSafeGlobDirs($root.'/*/docs/stories'),
        );
    }

    return array_values(array_unique($dirs));
}

/**
 * Extra trees for basename gate only (legacy loose + root/bashscripts).
 *
 * @return list<string>
 */
function bmadBasenameExtraDirectories(): array
{
    $moduleRoot = dirname(__DIR__, 4);
    $themesRoot = dirname(__DIR__, 5).'/Themes';
    $repoRoot = dirname(__DIR__, 6);

    $dirs = [];

    foreach ([$moduleRoot, $themesRoot] as $root) {
        if (! is_dir($root)) {
            continue;
        }

        $dirs = array_merge($dirs, bmadSafeGlobDirs($root.'/*/docs/bmad'));
    }

    foreach ([
        $repoRoot.'/docs/stories',
        $repoRoot.'/docs/bmad',
        $repoRoot.'/docs/bmad/stories',
        $repoRoot.'/bashscripts/docs/bmad/stories',
        $repoRoot.'/bashscripts/docs/stories',
    ] as $extra) {
        if (is_dir($extra)) {
            $dirs[] = $extra;
        }
    }

    return array_values(array_unique($dirs));
}

/**
 * @return list<string>
 */
function bmadStorySkipNames(): array
{
    return [
        '0000-template.story.md',
        '0000-story-template.md',
        'README.md',
        'INDEX.md',
        'index.md',
    ];
}

it('ogni BMAD story ha le sezioni MADR obbligatorie', function (): void {
    $required = [
        '## Context and Problem Statement',
        '## Decision Drivers',
        '## Considered Options',
        '## Decision Outcome',
        '### Consequences',
        '### Confirmation',
    ];

    $skipNames = bmadStorySkipNames();
    $offenders = [];

    foreach (bmadModuleThemeStoryDirectories() as $storiesDir) {
        $finder = Finder::create()
            ->files()
            ->in($storiesDir)
            ->name('*.story.md')
            ->depth('== 0');

        foreach ($finder as $file) {
            $name = $file->getFilename();
            if (in_array($name, $skipNames, true)) {
                continue;
            }

            $contents = $file->getContents();
            foreach ($required as $heading) {
                if (! str_contains($contents, $heading)) {
                    $offenders[] = ($file->getRealPath() ?: $file->getPathname()).' missing '.$heading;
                    break;
                }
            }
        }
    }

    expect($offenders)->toBe([]);
});

it('ogni BMAD story ha basename NNNN-slug.story.md', function (): void {
    $pattern = '/^\d{4}-[a-z0-9]+(?:-[a-z0-9]+)*\.story\.md$/';
    $template = '0000-template.story.md';
    $offenders = [];
    $seen = [];

    $dirs = array_merge(bmadModuleThemeStoryDirectories(), bmadBasenameExtraDirectories());

    foreach ($dirs as $storiesDir) {
        $finder = Finder::create()
            ->files()
            ->in($storiesDir)
            ->name('*.story.md')
            ->depth('< 4');

        foreach ($finder as $file) {
            $path = $file->getRealPath() ?: $file->getPathname();
            if (isset($seen[$path])) {
                continue;
            }
            $seen[$path] = true;

            $name = $file->getFilename();
            if ($name === $template) {
                continue;
            }

            if (preg_match($pattern, $name) !== 1) {
                $offenders[] = $path;
            }
        }
    }

    expect($offenders)->toBe([]);
});
