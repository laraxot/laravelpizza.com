<?php

declare(strict_types=1);

use Tests\TestCase;

/*
 * |--------------------------------------------------------------------------
 * | Test Case
 * |--------------------------------------------------------------------------
 * |
 * | Il TestCase di default per tutti i test del modulo Cms.
 * | Utilizza il TestCase globale di Laravel con setup specifico per frontend.
 * |
 */

uses(Modules\Cms\Tests\TestCase::class)->in('Feature', 'Unit');

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

expect()->extend('toBeSubclassOf', function (string $parentClass) {
    $class = $this->value;
    if (! is_string($class)) {
        throw new InvalidArgumentException('Expected a class name string');
    }

    return $this->and(is_subclass_of($class, $parentClass) || $class === $parentClass)->toBeTrue();
});

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
