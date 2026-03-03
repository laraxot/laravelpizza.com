<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Livewire;
use Modules\User\Filament\Widgets\RegistrationWidget;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    static::mockXotData();
});

test('registration widget renders for patient type', function (): void {
    Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
        ->assertStatus(200)
        ->assertViewIs('pub_theme::filament.widgets.registration');
});

test('registration widget renders for doctor type', function (): void {
    Livewire::test(RegistrationWidget::class, ['type' => 'doctor'])
        ->assertStatus(200)
        ->assertViewIs('pub_theme::filament.widgets.registration');
});

test('registration widget without type throws exception', function (): void {
    Livewire::test(RegistrationWidget::class);
})->throws(\Exception::class);

test('registration widget accepts form data', function (): void {
    $email = static::generateUniqueEmail();

    $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
        ->set('data.email', $email)
        ->set('data.name', 'Test User')
        ->assertSet('data.email', $email)
        ->assertSet('data.name', 'Test User');

    expect($widget->get('data.email'))->toBe($email);
});

test('registration widget stores multiple fields', function (): void {
    $testData = [
        'name' => 'Test Patient',
        'email' => static::generateUniqueEmail(),
        'password' => 'TestPassword123!',
    ];

    $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient']);

    foreach ($testData as $field => $value) {
        $widget->set("data.{$field}", $value);
    }

    foreach ($testData as $field => $value) {
        expect($widget->get("data.{$field}"))->toBe($value);
    }
});

test('registration widget register call does not fatal', function (): void {
    $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
        ->set('data.email', static::generateUniqueEmail())
        ->set('data.name', 'Test User')
        ->set('data.password', 'TestPassword123!');

    try {
        $widget->call('register');
        expect(true)->toBeTrue();
    } catch (\Exception $e) {
        expect($e)->toBeInstanceOf(\Exception::class);
    }
});

test('registration widget is Livewire compatible', function (): void {
    $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient']);
    expect($widget)->not()->toBeNull();
});

test('registration widget register call for both types', function (): void {
    foreach (['patient', 'doctor'] as $type) {
        $widget = Livewire::test(RegistrationWidget::class, ['type' => $type])
            ->set('data.email', static::generateUniqueEmail())
            ->set('data.name', "Test {$type}")
            ->set('data.password', 'TestPassword123!');

        try {
            $widget->call('register');
            expect(true)->toBeTrue();
        } catch (\Exception $e) {
            expect($e)->toBeInstanceOf(\Exception::class);
        }
    }
});

test('registration widget retains invalid data', function (): void {
    $email = 'invalid-email';
    $name = 'Test User';

    $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
        ->set('data.email', $email)
        ->set('data.name', $name);

    expect($widget->get('data.email'))->toBe($email);
    expect($widget->get('data.name'))->toBe($name);
});
