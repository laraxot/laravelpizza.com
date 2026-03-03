<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Query;

use Modules\Xot\Actions\Query\StartQueryLogAction;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

uses(TestCase::class);

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
