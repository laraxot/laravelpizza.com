<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('login widget binds form state via data property on submit', function (): void {
    /** @var User $user */
    $user = UserFactory::new()->createOne([
        'email' => 'login-state@example.com',
        'password' => Hash::make('SecretPass123!'),
    ]);

    Livewire::test(LoginWidget::class)
        ->set('data.email', 'login-state@example.com')
        ->set('data.password', 'SecretPass123!')
        ->call('save')
        ->assertHasNoErrors();

    Assert::assertTrue(auth()->check());
    Assert::assertSame($user->id, auth()->id());
});
