<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Mockery\MockInterface;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Pages\BaseSettingPage;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/**
 * Xot non deve dipendere dai moduli foglia: una pagina concreta minima basta per il gate.
 *
 * @return class-string<BaseSettingPage>
 */
function baseSettingPageTestClass(): string
{
    $page = new class extends BaseSettingPage {};

    return $page::class;
}

test('base setting page is abstract so Filament discovery skips it', function (): void {
    expect((new ReflectionClass(BaseSettingPage::class))->isAbstract())->toBeTrue();
});

test('only super-admin can access a setting page', function (bool $isSuperAdmin): void {
    /** @var UserContract&MockInterface $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturn($isSuperAdmin);

    Filament::auth()->setUser($user);

    expect(baseSettingPageTestClass()::canAccess())->toBe($isSuperAdmin);
})->with([
    'super-admin' => [true],
    'other user' => [false],
]);

test('guest cannot access a setting page', function (): void {
    Filament::auth()->logout();

    expect(baseSettingPageTestClass()::canAccess())->toBeFalse();
});
