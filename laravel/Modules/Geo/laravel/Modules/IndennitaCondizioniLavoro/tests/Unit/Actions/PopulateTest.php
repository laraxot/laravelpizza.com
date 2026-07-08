<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Actions\Populate;
use PHPUnit\Framework\Assert;

test('populate returns without querying for non-positive values', function (): void {
    $action = new Populate();
    $thrown = false;

    try {
        $action->execute(['anno' => 0, 'quadrimestre' => 1]);
        $action->execute(['anno' => 2026, 'quadrimestre' => 0]);
    } catch (Throwable) {
        $thrown = true;
    }

    Assert::assertFalse($thrown);
});
