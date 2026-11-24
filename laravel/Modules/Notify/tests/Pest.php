<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo Notify.
 *
 * Questo file NON viene caricato. `Pest\Bootstrappers\BootFiles` legge `Pest.php`,
 * `Helpers.php` ed `Expectations.php` da un solo percorso per run — quello della root —
 * quindi ogni funzione o `pest()->extend()` dichiarato qui è codice morto.
 *
 * Regole, non negoziabili:
 * - zero funzioni libere qui dentro (`grep -c '^function ' ` deve dare 0);
 * - vietati `pest()->extend()` e `pest()->uses()` (PHPStan `method.internalClass`);
 * - ogni file di test dichiara `uses(\Modules\Notify\Tests\TestCase::class)` dopo il blocco `use` —
 *   un `pest()->extend()` scritto qui non verrebbe applicato;
 * - vietata la cartella `tests/Support/` per helper Pest (ADR-002): helper condivisi
 *   vanno in `Modules\Xot\Tests\XotBasePest` o in `Tests\TestCase`.
 */
