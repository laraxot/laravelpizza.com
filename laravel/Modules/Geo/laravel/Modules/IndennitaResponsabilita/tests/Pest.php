<?php

declare(strict_types=1);

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Tests\TestCase;

// @phpstan-ignore-next-line method.internalClass
uses(TestCase::class)->in("Feature", "Unit");

/**
 * @param array{} $attributes
 */
function createIndennitaResponsabilita(array $attributes = []): IndennitaResponsabilita
{
    $record = new IndennitaResponsabilita();
    $record->fill($attributes);
    $record->save();

    return $record;
}
