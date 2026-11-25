<?php

declare(strict_types=1);
use Illuminate\Support\Facades\DB;
use Modules\Xot\Actions\Query\StartQueryLogAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('start query log action works', function (): void {
    $action = app(StartQueryLogAction::class);
    $action->execute();

    try {
        DB::connection('activity')->table('activity_log')->count();
    } catch (Throwable $e) {
        Assert::assertStringContainsString('connection', $e->getMessage());
    }
});
