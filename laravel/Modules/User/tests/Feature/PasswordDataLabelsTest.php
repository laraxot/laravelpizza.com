<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Livewire\Livewire;
use Modules\User\Datas\PasswordData;
use Modules\User\Http\Livewire\Auth\Login;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('password data labels are translated', function (): void {
    // Arrange
    app()->setLocale('it');

    $passwordData = PasswordData::make();
    $passwordData->setFieldName('password');

    // Act
    $passwordComponent = $passwordData->getPasswordFormComponent('password');
    $confirmationComponent = $passwordData->getPasswordConfirmationFormComponent();

    // Assert
    expect($passwordComponent->getLabel())->toBe('Password');
    expect($confirmationComponent->getLabel())->toBe('Conferma Password');
});

test('login form labels are translated', function (): void {
    // Assemble
    app()->setLocale('it');

    // Using Livewire test helper
    $livewire = Livewire::test(Login::class);
    $instance = $livewire->instance();

    // Filament forms are initialized on mount or when accessed.
    $instance->mount();

    $form = $instance->getForm('form');
    $components = $form->getComponents();

    // Find components
    $email = collect($components)->first(fn ($c) => $c->getName() === 'email');
    $password = collect($components)->first(fn ($c) => $c->getName() === 'password');
    $remember = collect($components)->first(fn ($c) => $c->getName() === 'remember');

    // Assert
    expect($email)->not->toBeNull();
    expect($email->getLabel())->toBe('Email');

    expect($password)->not->toBeNull();
    expect($password->getLabel())->toBe('Password');

    expect($remember)->not->toBeNull();
    expect($remember->getLabel())->toBe('Ricordami');
});
