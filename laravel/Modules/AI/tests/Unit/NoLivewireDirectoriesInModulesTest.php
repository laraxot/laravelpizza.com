<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;
use Webmozart\Assert\Assert;

use function Safe\glob;

uses(TestCase::class)->group('no-xot-db');

/**
 * Guardia lw2fw-01: nessun modulo ha piu' una cartella Livewire.
 *
 * I componenti Livewire sono stati sostituiti da widget Filament. Una directory
 * `app/Http/Livewire` (o `User/app/Livewire`) ricomparsa, anche vuota o con il solo
 * `_components.json`, e' una regressione: la registrazione automatica non esiste piu'.
 *
 * @see Modules/Xot/docs/bmad/stories/lw2fw-01.livewire-to-filament.story.md
 */
it('non esiste alcuna cartella Modules/*/app/Http/Livewire', function (): void {
    $patterns = [
        base_path('Modules/*/app/Http/Livewire'),
        base_path('Modules/*/*/app/Http/Livewire'),
    ];

    $found = [];
    foreach ($patterns as $pattern) {
        $matches = glob($pattern, GLOB_ONLYDIR);
        Assert::allString($matches);
        $found = array_merge($found, $matches);
    }

    expect($found)->toBe([], 'Cartelle Livewire residue: '.implode(', ', $found));
});

it('non esiste Modules/User/app/Livewire', function (): void {
    expect(is_dir(base_path('Modules/User/app')))->toBeTrue();
    expect(is_dir(base_path('Modules/User/app/Livewire')))->toBeFalse();
});
