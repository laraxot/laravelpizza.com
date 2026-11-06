<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Modules\Activity\Actions\ActivityLogger as ActivityLoggerAction;
use Modules\Activity\Adapters\ActivityLogger as ActivityLoggerAdapter;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

test('ActivityLogger Action custom delega a log', function (): void {
    $activity = new Activity;

    /** @var ActivityLoggerAction&Mockery\MockInterface $logger */
    $logger = Mockery::mock(ActivityLoggerAction::class)->makePartial();
    mockeryExpect($logger->shouldReceive('log'))
        ->once()
        ->with('evt', null, null, null, 'Descrizione')
        ->andReturn($activity);

    Assert::assertSame($activity, $logger->custom('evt', 'Descrizione'));
});

test('ActivityLogger Action getByType rifiuta type vuoto', function (): void {
    expect(fn (): Collection => (new ActivityLoggerAction)->getByType(''))
        ->toThrow(\InvalidArgumentException::class);
});

test('ActivityLogger Adapter login e logout sono invocabili con partial mock', function (): void {
    $activity = new Activity;
    $user = new User;

    /** @var ActivityLoggerAdapter&Mockery\MockInterface $logger */
    $logger = Mockery::mock(ActivityLoggerAdapter::class)->makePartial();
    mockeryExpect($logger->shouldReceive('login'))->once()->with($user)->andReturn($activity);
    mockeryExpect($logger->shouldReceive('logout'))->once()->with($user)->andReturn($activity);

    Assert::assertSame($activity, $logger->login($user));
    Assert::assertSame($activity, $logger->logout($user));
});
