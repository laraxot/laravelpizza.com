<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

uses(TestCase::class);

/**
 * `UserOverview` mostra in testa alla lista utenti quattro statistiche di sintesi
 * (totali, attivi, email verificate, accessi 24h): il vecchio placeholder con `$record` non esiste piu'.
 *
 * @return list<Stat>
 */
function userOverviewStats(): array
{
    $stats = (new ReflectionMethod(UserOverview::class, 'getStats'))->invoke(new UserOverview);
    Assert::assertIsArray($stats);

    $result = [];
    foreach ($stats as $stat) {
        Assert::assertInstanceOf(Stat::class, $stat);
        $result[] = $stat;
    }

    return $result;
}

test('user overview widget extends the xot stats overview base', function (): void {
    Assert::assertSame(XotBaseStatsOverviewWidget::class, get_parent_class(UserOverview::class));
});

test('user overview widget exposes total, active, verified and recent login stats', function (): void {
    TestCase::skipUnlessUsersTableReady();
    TestCase::skipUnlessUserTable('authentication_logs');

    $stats = userOverviewStats();
    $keys = ['total', 'active', 'verified', 'recent_logins'];

    Assert::assertCount(count($keys), $stats);
    foreach ($keys as $index => $key) {
        Assert::assertSame(trans('user::user.widgets.overview.'.$key.'.label'), $stats[$index]->getLabel());
        Assert::assertSame(trans('user::user.widgets.overview.'.$key.'.description'), $stats[$index]->getDescription());
    }
});

test('user overview widget shows the verified stat as a percentage', function (): void {
    TestCase::skipUnlessUsersTableReady();
    TestCase::skipUnlessUserTable('authentication_logs');

    $verified = userOverviewStats()[2]->getValue();

    Assert::assertIsString($verified);
    Assert::assertStringEndsWith('%', $verified);
});
