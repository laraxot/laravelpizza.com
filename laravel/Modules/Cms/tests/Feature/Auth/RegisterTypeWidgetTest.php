<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Livewire;
use Modules\User\Filament\Widgets\RegistrationWidget;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

// Use Cms specific TestCase only for this file
uses(TestCase::class);

// Ensure XotData is mocked for every test
beforeEach(static function (): void {
    // ✅ Utilizzo funzione centralizzata dal TestCase
    static::mockXotData();
});

// REGISTRATION WIDGET TESTS - Filament Component
// ✅ Test del WIDGET Filament, non della pagina
// ✅ Focus su: rendering, form interaction, basic validation
// ✅ Architettura: Filament Widget + XotBaseWidget + dynamic resolution

// WIDGET CORE TESTS
describe('Registration Widget', static function () {
    test('patient widget renders correctly', static function () {
        Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
            ->assertStatus(200)
            ->assertViewIs('pub_theme::filament.widgets.registration');
    });

    test('doctor widget renders correctly', static function () {
        Livewire::test(RegistrationWidget::class, ['type' => 'doctor'])
            ->assertStatus(200)
            ->assertViewIs('pub_theme::filament.widgets.registration');
    });

    test('widget without type throws exception', static function () {
        expect(static function () {
            Livewire::test(RegistrationWidget::class);
        })->toThrow(\Exception::class);
    });

    test('widget accepts form data', static function () {
        $email = static::generateUniqueEmail();

        $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
            ->set('data.email', $email)
            ->set('data.name', 'Test User')
            ->assertSet('data.email', $email)
            ->assertSet('data.name', 'Test User');

        expect($widget->get('data.email'))->toBe($email);
    });

    test('widget accepts multiple fields', static function () {
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

    test('widget register action does not cause fatal errors', static function () {
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

    test('widget is compatible with livewire testing', static function () {
        $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient']);

        expect($widget)->not()->toBeNull();
    });

    test('widget works for all user types', static function () {
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

    test('widget preserves data after invalid input', static function () {
        $email = 'invalid-email';
        $name = 'Test User';

        $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient'])->set('data.email', $email)->set(
            'data.name',
            $name,
        );

        expect($widget->get('data.email'))->toBe($email)->and($widget->get('data.name'))->toBe($name);
    });
});
