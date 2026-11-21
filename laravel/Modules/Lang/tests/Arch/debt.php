<?php

declare(strict_types=1);

/*
 * Debito di architettura di Modules\Lang: classi che oggi violano una regola di Modules/Xot/tests/Arch/ArchitectureTest.php.
 * Misurato il 2026-11-18. Solo in discesa: chi corregge una classe la toglie, chi aggiunge una voce lo spiega nella PR.
 * Ogni voce deve stare nel namespace di questo pacchetto (lo verifica ArchitectureTest).

 * ADR: Modules/Xot/docs/adr/architecture-tests-pest-arch.md
 */

return [
    // funzioni di debug o deprecate (dd, dump, print_r, var_export, debug_backtrace…)
    'php' => [
        'Modules\Lang\Actions\CleanPlaceholderTranslationsAction',
        'Modules\Lang\Actions\Filament\AutoLabelAction',
    ],
    // md5/sha1/uniqid/rand/extract nel codice di produzione: quasi sempre usi non crittografici (chiavi di cache, id), da rivedere uno per uno; factory e seeder sono esclusi a parte
    'security' => [
        'Modules\Lang\View\Components\LanguageSwitcher',
    ],
];
