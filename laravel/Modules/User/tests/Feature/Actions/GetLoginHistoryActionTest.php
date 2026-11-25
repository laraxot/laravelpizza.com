<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Modules\User\Actions\Login\GetLoginHistoryAction;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    TestCase::skipUnlessUserTable('authentication_logs');
});

/**
 * @param  array{login_at?: string, login_successful?: bool}  $overrides
 */
function insertAuthLoginLog(array $overrides = []): void
{
    DB::connection('user')->table('authentication_logs')->insert([
        'authenticatable_type' => 'user',
        'authenticatable_id' => 1,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'pest',
        'login_at' => $overrides['login_at'] ?? CarbonImmutable::now('UTC')->toDateTimeString(),
        'login_successful' => $overrides['login_successful'] ?? true,
        'logout_at' => null,
        'cleared_by_user' => false,
        'location' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

/**
 * Differenza bucket-per-bucket tra due serie allineate: isola i
 * contributi del test dal dato pre-esistente in authentication_logs.
 *
 * @param  array{labels: list<string>, data: list<int>}  $before
 * @param  array{labels: list<string>, data: list<int>}  $after
 * @return list<int>
 */
function seriesDiff(array $before, array $after): array
{
    expect($before['labels'])->toBe($after['labels']);

    return array_map(
        static fn (int $a, int $b): int => $b - $a,
        $before['data'],
        $after['data'],
    );
}

test('day granularity counts every login attempt and zero-fills gaps', function (): void {
    $action = app(GetLoginHistoryAction::class);
    $today = CarbonImmutable::now('UTC')->startOfDay();
    $twoDaysAgo = $today->subDays(2);

    $before = $action->execute($twoDaysAgo, 'day');

    $now = CarbonImmutable::now('UTC');

    insertAuthLoginLog(['login_at' => $twoDaysAgo->addHours(10)->toDateTimeString()]);
    insertAuthLoginLog(['login_at' => $now->subHours(3)->toDateTimeString()]);
    insertAuthLoginLog(['login_at' => $now->subHour()->toDateTimeString()]);
    insertAuthLoginLog([
        'login_at' => $now->subMinutes(10)->toDateTimeString(),
        'login_successful' => false,
    ]);

    $after = $action->execute($twoDaysAgo, 'day');

    expect(seriesDiff($before, $after))->toBe([1, 0, 3]);
});

test('month granularity groups logins by month', function (): void {
    $action = app(GetLoginHistoryAction::class);
    $now = CarbonImmutable::now('UTC');
    $since = $now->subMonths(2);
    $lastMonth = $now->subMonth()->startOfMonth()->addDays(3);

    $before = $action->execute($since, 'month');

    insertAuthLoginLog(['login_at' => $lastMonth->toDateTimeString()]);
    insertAuthLoginLog(['login_at' => $lastMonth->addHour()->toDateTimeString()]);
    insertAuthLoginLog(['login_at' => $now->toDateTimeString()]);

    $after = $action->execute($since, 'month');

    expect(seriesDiff($before, $after))->toBe([0, 2, 1]);
});

test('null since resolves the oldest login', function (): void {
    $action = app(GetLoginHistoryAction::class);
    $old = CarbonImmutable::now('UTC')->subDays(10)->startOfDay()->addHours(8);

    insertAuthLoginLog(['login_at' => $old->toDateTimeString()]);

    $result = $action->execute(null, 'month');

    $index = array_search($old->format('m/Y'), $result['labels'], true);

    if ($index === false) {
        throw new RuntimeException('Month bucket label not found in history labels.');
    }

    expect($result['data'][$index])->toBeGreaterThanOrEqual(1);
});

test('series total matches every authentication log row in range', function (): void {
    $since = CarbonImmutable::now('UTC')->subYear();
    $action = app(GetLoginHistoryAction::class);

    insertAuthLoginLog([
        'login_at' => CarbonImmutable::now('UTC')->subDays(3)->toDateTimeString(),
    ]);
    insertAuthLoginLog([
        'login_at' => CarbonImmutable::now('UTC')->subDays(2)->toDateTimeString(),
        'login_successful' => false,
    ]);

    $result = $action->execute($since, 'month');

    $expected = DB::connection('user')->table('authentication_logs')
        ->whereNotNull('login_at')
        ->where('login_at', '>=', $since->toDateTimeString())
        ->where('login_at', '<=', CarbonImmutable::now('UTC')->toDateTimeString())
        ->count();

    expect($result['labels'])->toHaveCount(count($result['data']))
        ->and(array_sum($result['data']))->toBe($expected);
});

test('invalid granularity throws', function (): void {
    app(GetLoginHistoryAction::class)->execute(null, 'week');
})->throws(InvalidArgumentException::class);
