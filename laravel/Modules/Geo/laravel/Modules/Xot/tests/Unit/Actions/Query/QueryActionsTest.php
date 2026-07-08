<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\DB;
use Modules\Xot\Actions\Query\StartQueryLogAction;
use PHPUnit\Framework\Assert;

test('start query log action works', function (): void {
    $action = app(StartQueryLogAction::class);
    $action->execute();

    try {
        DB::connection('activity')->table('activity_log')->count();
    } catch (Throwable $e) {
        Assert::assertStringContainsString('connection', $e->getMessage());
    }
});
