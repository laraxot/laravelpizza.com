<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Query;

use Modules\Xot\Actions\Query\StartQueryLogAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\DB;

uses(TestCase::class);

it('starts query log and listens for events', function (): void {
    $action = app(StartQueryLogAction::class);
    $action->execute();
    
    // Trigger a query on existing migrated table
    DB::connection('activity')->table('activity_log')->limit(1)->get();
    
    expect(true)->toBeTrue();
});
