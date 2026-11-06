<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo User.
 *
 * Questo file NON viene caricato. `Pest\Bootstrappers\BootFiles` legge `Pest.php`,
 * `Helpers.php` ed `Expectations.php` da un solo percorso per run — quello della root —
 * quindi `expect()->extend()` e funzioni dichiarate qui sono codice morto.
 *
 * Regole, non negoziabili:
 * - il TestCase si lega per file: ogni test dichiara `uses(\Modules\User\Tests\TestCase::class)`
 *   (eventualmente con `->group(...)`); un `pest()->extend()->in(...)` qui colliderebbe
 *   con quei file (TestCaseAlreadyInUse) e bloccherebbe la raccolta;
 * - vietati `pest()->extend()`, `pest()->uses()` ed `expect()->extend()` in questo file;
 * - helper condivisi: `Modules\User\Tests\Support\helpers.php` (autoload-dev composer) o
 *   metodi statici su `Modules\User\Tests\TestCase` / `Modules\Xot\Tests\XotBasePest`;
 * - se servono expectation custom, vanno aggiunte nel `tests/Pest.php` ROOT, non qui.
 */
