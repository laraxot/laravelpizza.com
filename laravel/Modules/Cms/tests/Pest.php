<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo Cms.
 * Helper globali (cmsHomepageBlocks, cmsGet, …) in PestHelpers.php.
 * Binding TestCase solo qui: i file test non dichiarano uses(TestCase) ridondanti.
 * @see docs/stories/phpstan-cms-zero.story.md
 */
require_once __DIR__.'/PestHelpers.php';

uses(\Modules\Cms\Tests\TestCase::class)->in(__DIR__.'/Feature', __DIR__.'/Unit');

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
