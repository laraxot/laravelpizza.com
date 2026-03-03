<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

pest()->extend(\Tests\TestCase::class)
    ->in('Feature')
    ->in('Unit')
    ->in('tests/Feature')
    ->in('tests/Unit')
    ->in('Modules/*/tests/Feature')
    ->in('Modules/*/tests/Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});
