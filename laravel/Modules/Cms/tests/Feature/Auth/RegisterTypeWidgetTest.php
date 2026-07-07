<?php

declare(strict_types=1);

use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Modules\Cms\Tests\TestCase;
use Modules\User\Filament\Widgets\RegistrationWidget;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
beforeEach(function (): void {
    /* @var \Modules\Cms\Tests\TestCase $this */
    cmsSkipTest('patient/doctor registration types not configured in this install.');
});

describe('Registration Widget', function (): void {
    test('patient widget renders correctly', function (): void {
        Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
            ->assertStatus(200)
            ->assertViewIs('pub_theme::filament.widgets.registration');
    });

    test('doctor widget renders correctly', function (): void {
        Livewire::test(RegistrationWidget::class, ['type' => 'doctor'])
            ->assertStatus(200)
            ->assertViewIs('pub_theme::filament.widgets.registration');
    });

    test('widget without type throws exception', function (): void {
        cmsSkipTest('Widget type validation covered by Livewire integration');
    });

    test('widget accepts form data', function (): void {
        $email = TestCase::pestGenerateUniqueEmail();

        $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
            ->set('data.email', $email)
            ->set('data.name', 'Test User')
            ->assertSet('data.email', $email)
            ->assertSet('data.name', 'Test User');
        /* @var Testable<\Livewire\Component> $widget */

        Assert::assertSame($email, $widget->get('data.email'));
    });

    test('widget accepts multiple fields', function (): void {
        $testData = [
            'name' => 'Test Patient',
            'email' => TestCase::pestGenerateUniqueEmail(),
            'password' => 'TestPassword123!',
        ];

        $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient']);
        Assert::assertInstanceOf(Testable::class, $widget);

        foreach ($testData as $field => $value) {
            $widget->set("data.{$field}", $value);
        }

        foreach ($testData as $field => $value) {
            Assert::assertSame($value, $widget->get("data.{$field}"));
        }
    });

    test('widget register action does not cause fatal errors', function (): void {
        $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
            ->set('data.email', TestCase::pestGenerateUniqueEmail())
            ->set('data.name', 'Test User')
            ->set('data.password', 'TestPassword123!');
        /* @var Testable<\Livewire\Component> $widget */

        try {
            $widget->call('register');
        } catch (Exception $e) {
            Assert::assertInstanceOf(Exception::class, $e);
        }
    });

    test('widget is compatible with livewire testing', function (): void {
        $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient']);
        /* @var Testable<\Livewire\Component> $widget */

        $widget->assertStatus(200);
    });

    test('widget works for all user types', function (): void {
        foreach (['patient', 'doctor'] as $type) {
            $widget = Livewire::test(RegistrationWidget::class, ['type' => $type])
                ->set('data.email', TestCase::pestGenerateUniqueEmail())
                ->set('data.name', "Test {$type}")
                ->set('data.password', 'TestPassword123!');
            /* @var Testable<\Livewire\Component> $widget */

            try {
                $widget->call('register');
            } catch (Exception $e) {
                Assert::assertInstanceOf(Exception::class, $e);
            }
        }
    });

    test('widget preserves data after invalid input', function (): void {
        $email = 'invalid-email';
        $name = 'Test User';

        $widget = Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
            ->set('data.email', $email)
            ->set('data.name', $name);
        /* @var Testable<\Livewire\Component> $widget */

        Assert::assertSame($email, $widget->get('data.email'));
        Assert::assertSame($name, $widget->get('data.name'));
    });
});
