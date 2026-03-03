<?php

declare(strict_types=1);

use Tests\TestCase;

/*
 * |--------------------------------------------------------------------------
 * | Test Case
 * |--------------------------------------------------------------------------
 * |
 * | Il TestCase di default per tutti i test del modulo Xot.
 * | Estende il TestCase specifico del modulo che fornisce il setup necessario.
 * |
 */

uses(TestCase::class)->in(__DIR__.'/Feature', __DIR__.'/Unit');

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
