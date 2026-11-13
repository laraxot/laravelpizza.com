<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Adapters;

use Mockery;
use Modules\Activity\Actions\Query\GetSubjectActivityLogAction;
use Modules\Activity\Actions\RecordSubjectActivityAction;
use Modules\Activity\Adapters\ActivityRecorder;
use Modules\Activity\Models\Activity;
<<<<<<< .merge_file_BNSoEI
use PHPUnit\Framework\Assert;

=======
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

>>>>>>> .merge_file_ejQsUq
afterEach(function (): void {
    Mockery::close();
});

test('ActivityRecorder record delega a RecordSubjectActivityAction', function (): void {
<<<<<<< .merge_file_BNSoEI
    $activity = new Activity();
=======
    $activity = new Activity;
>>>>>>> .merge_file_ejQsUq

    $mock = Mockery::mock(RecordSubjectActivityAction::class);
    mockeryExpect($mock->shouldReceive('execute'))
        ->once()
        ->with('Modules\\User\\Models\\User', 42, 'updated', ['name' => 'old'], null)
        ->andReturn($activity);
    app()->instance(RecordSubjectActivityAction::class, $mock);

<<<<<<< .merge_file_BNSoEI
    (new ActivityRecorder())->record(
=======
    (new ActivityRecorder)->record(
>>>>>>> .merge_file_ejQsUq
        'Modules\\User\\Models\\User',
        42,
        'updated',
        ['name' => 'old'],
    );
});

test('ActivityRecorder getLog delega a GetSubjectActivityLogAction', function (): void {
    $logEntries = [['id' => 1, 'event' => 'updated']];

    $mock = Mockery::mock(GetSubjectActivityLogAction::class);
    mockeryExpect($mock->shouldReceive('execute'))
        ->once()
        ->with('Modules\\User\\Models\\User', 7)
        ->andReturn($logEntries);
    app()->instance(GetSubjectActivityLogAction::class, $mock);

<<<<<<< .merge_file_BNSoEI
    $result = (new ActivityRecorder())->getLog('Modules\\User\\Models\\User', 7);
=======
    $result = (new ActivityRecorder)->getLog('Modules\\User\\Models\\User', 7);
>>>>>>> .merge_file_ejQsUq

    Assert::assertSame($logEntries, $result);
});
