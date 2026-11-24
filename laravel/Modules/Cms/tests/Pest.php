<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo Cms.
 * Helper globali (cmsHomepageBlocks, cmsGet, …) in PestHelpers.php.
 * Nessun binding del TestCase qui: Pest esegue solo laravel/tests/Pest.php, quindi ogni file test lega
 * il proprio TestCase con uses(TestCase::class). Un uses()->in() in questo file non girerebbe mai e fa
 * segnalare dal plugin PHPStan di Pest come ridondanti i binding per file che invece servono.
 *
 * @see Modules/Cms/docs/testing.md#binding-del-testcase
 * @see docs/stories/phpstan-cms-zero.story.md
 */
require_once __DIR__.'/PestHelpers.php';

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
 * | Qui puoi definire aspettative globali per il modulo Cms.
 * | Quando definisci here expectation globali, saranno disponibili
 * | in tutti i test del modulo.
 * |
 */

// expect()->extend('toBeValidHtml', function () {
//     return $this->toContain('<html');
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

// function createTestUser() {
//     return User::factory()->create();
// }
