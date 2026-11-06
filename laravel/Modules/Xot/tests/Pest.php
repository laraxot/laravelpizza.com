<?php

declare(strict_types=1);

/*
 * |--------------------------------------------------------------------------
 * | Test Case
 * |--------------------------------------------------------------------------
 * |
 * | Il TestCase del modulo Xot (Modules\Xot\Tests\TestCase) si lega file per file.
 * |
 */

// Niente pest()->extend(TestCase::class)->in('Feature', 'Unit') qui: ogni file *Test.php
// dichiara gia' uses(TestCase::class). Con entrambi Pest lancia TestCaseAlreadyInUse in
// raccolta e non gira nessun test. Si tiene uses() nel file: e' la maggioranza e permette
// a PHPStan di tipizzare $this. Un nuovo file di test deve aggiungere la sua uses().

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
 * | Qui puoi definire aspettative globali per il modulo Xot.
 * | Quando definisci here expectation globali, saranno disponibili
 * | in tutti i test del modulo.
 * |
 */

// expect()->extend('toBeOne', function () {
//     return $this->toBe(1);
// });

/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 * |
 * | Qui puoi definire funzioni helper globali per i test del modulo.
 * | Queste funzioni saranno disponibili in tutti i test.
 * |
 */

// function something() {
//     // ...
// }
