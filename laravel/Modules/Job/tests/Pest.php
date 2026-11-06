<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo Job.
 *
 * Questo file NON viene caricato. `Pest\Bootstrappers\BootFiles` legge `Pest.php`,
 * `Helpers.php` ed `Expectations.php` da un solo percorso per run — quello della root —
 * quindi ogni funzione dichiarata qui è codice morto e i test che la chiamano falliscono
 * con `Call to undefined function`.
 *
 * Regole, non negoziabili:
 * - zero funzioni libere qui dentro (`grep -c '^function ' ` deve dare 0);
 * - helper condivisi: metodi statici su `Modules\Xot\Tests\XotBasePest` (autoload PSR-4,
 *   niente `require_once`);
 * - helper di dominio: metodi statici su `Modules\Job\Tests\TestCase`;
 * - ogni file di test dichiara `uses(\Modules\Job\Tests\TestCase::class)` in testa —
 *   un `uses()->in(...)` scritto qui non verrebbe applicato;
 * - vietati `pest()->extend()` e `pest()->uses()` (PHPStan `method.internalClass`);
 * - vietata la cartella `tests/Support/` per helper Pest (ADR-002).
 */
