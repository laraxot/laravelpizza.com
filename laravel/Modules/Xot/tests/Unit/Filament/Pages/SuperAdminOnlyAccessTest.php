<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Mockery\MockInterface;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Pages\ArtisanCommandsManager;
use Modules\Xot\Filament\Pages\EnvPage;
use Modules\Xot\Filament\Pages\HealthPage;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;
use Modules\Xot\Filament\Widgets\EnvWidget;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/*
 * Pagine che eseguono Artisan, leggono/scrivono .env o mostrano lo stato del server:
 * Filament le apre a chiunque entri nel pannello se `canAccess()` non è ridefinito.
 * Ogni voce porta la classe e la closure che ne legge `canAccess()` (tipizzata, senza mixed).
 */
dataset('super admin only classes', [
    'artisan commands manager' => [ArtisanCommandsManager::class, fn (): bool => ArtisanCommandsManager::canAccess()],
    'env page' => [EnvPage::class, fn (): bool => EnvPage::canAccess()],
    'health page' => [HealthPage::class, fn (): bool => HealthPage::canAccess()],
    'env widget' => [EnvWidget::class, fn (): bool => EnvWidget::canAccess()],
]);

test('operational class uses the super-admin trait', function (string $class): void {
    expect(class_uses_recursive($class))->toContain(SuperAdminOnlyTrait::class);
})->with('super admin only classes');

test('only super-admin can access an operational class', function (string $class, Closure $canAccess, bool $isSuperAdmin): void {
    /** @var UserContract&MockInterface $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturn($isSuperAdmin);

    Filament::auth()->setUser($user);

    expect($canAccess())->toBe($isSuperAdmin);
})->with('super admin only classes')->with([
    'super-admin' => [true],
    'other user' => [false],
]);

test('guest cannot access an operational class', function (string $class, Closure $canAccess): void {
    Filament::auth()->logout();

    expect($canAccess())->toBeFalse();
})->with('super admin only classes');

test('env widget is hidden from users who are not super-admin', function (): void {
    /** @var UserContract&MockInterface $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')->with('super-admin')->andReturn(false);

    Filament::auth()->setUser($user);

    expect(EnvWidget::canView())->toBeFalse();
});
