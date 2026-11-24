<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class);

/**
 * Ogni modulo e tema mantenuto deve spiegare l'uso per gli attori reali.
 * Il manuale non sostituisce policy e test: impedisce solo che la documentazione
 * owner sparisca o ometta la matrice minima degli attori.
 *
 * @see Modules/Xot/docs/stories/actor-user-manuals.story.md
 */
test('ogni modulo e tema ha il manuale d uso per gli attori', function (): void {
    $root = dirname(__DIR__, 5);
    $packages = [
        ...glob($root.'/Modules/*', GLOB_ONLYDIR),
        ...glob($root.'/Themes/*', GLOB_ONLYDIR),
    ];
    $missing = [];
    $incomplete = [];
    $missingArtifacts = [];

    foreach ($packages as $package) {
        if (! is_string($package) || (! is_file($package.'/module.json') && ! is_file($package.'/theme.json') && ! is_file($package.'/composer.json'))) {
            continue;
        }

        $manual = $package.'/docs/manuale-uso-attori.md';
        if (! is_file($manual)) {
            $missing[] = substr($manual, strlen($root) + 1);

            continue;
        }

        $manualsPath = $package.'/docs/manuals';
        if (! is_file($manualsPath.'/manuale-utente.md')) {
            $missingArtifacts[] = substr($manualsPath, strlen($root) + 1).'/manuale-utente.md';
        }
        if (! is_file($manualsPath.'/manuale-utente.pdf')) {
            $missingArtifacts[] = substr($manualsPath, strlen($root) + 1).'/manuale-utente.pdf';
        }
        if (glob($manualsPath.'/assets/*.png') === []) {
            $missingArtifacts[] = substr($manualsPath, strlen($root) + 1).'/assets/*.png';
        }

        $contents = file_get_contents($manual);
        foreach (['ospite', 'autenticat', 'gruppo|team', 'admin', 'super-admin|superadmin'] as $actor) {
            if (preg_match('/'.$actor.'/i', $contents) !== 1) {
                $incomplete[] = substr($manual, strlen($root) + 1).': '.$actor;
            }
        }
    }

    Assert::assertSame([], $missing);
    Assert::assertSame([], $incomplete);
    Assert::assertSame([], $missingArtifacts);
});
