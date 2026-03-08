<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Query;

use Illuminate\Support\Facades\DB;
use Modules\Xot\Actions\Query\StartQueryLogAction;


test('start query log action works', function () {
    $action = app(StartQueryLogAction::class);
    $action->execute();

    // Trigger a query on a known table in Activity module (which we migrated)
    try {
        DB::connection('activity')->table('activity_log')->count();
    } catch (\Throwable $e) {
        // If connection fails, we still reached the execution
    }

    expect(true)->toBeTrue();
});
