<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo Cms.
 * Helper globali (cmsHomepageBlocks, cmsGet, …) in PestHelpers.php.
 * Il binding canonico vive in `Pest.php`; questo file storico viene mantenuto
 * solo per compatibilità con runner che cercano il nome lowercase.
 * @see docs/stories/phpstan-cms-zero.story.md
 *
 * Nota: su FS case-sensitive esistono sia Pest.php sia pest.php (variante storica).
 * Non dichiarare qui un secondo binding: Pest carica entrambi su alcuni runner.
 */
require_once __DIR__.'/PestHelpers.php';


/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 */

// expect()->extend('toBeValidHtml', function () {
//     return $this->toContain('<html');
// });

/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 */

// function createTestUser() {
//     return User::factory()->create();
// }
