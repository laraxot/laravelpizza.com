<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\IndennitaCondizioniLavoro\Tests\TestCase;

pest()->uses(TestCase::class)->in('Feature', 'Unit');

expect()->extend('toBeCondizioniLavoro', fn () => $this->toBeInstanceOf(CondizioniLavoro::class));

/**
 * @param array<string, int|string|null> $attributes
 */
function createCondizioniLavoro(array $attributes = []): CondizioniLavoro
{
    return new CondizioniLavoro($attributes);
}
