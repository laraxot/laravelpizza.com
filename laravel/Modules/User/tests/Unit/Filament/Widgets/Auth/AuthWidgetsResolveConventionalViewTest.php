<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\User\Filament\Widgets\Auth\ForgotPasswordWidget;
use Modules\User\Filament\Widgets\Auth\ResetPasswordWidget;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Un widget che estende XotBaseWidget non dichiara `$view`: la vista la risolve
 * GetViewByClassAction dal nome della classe, prima nel tema (`pub_theme::`) e poi nel modulo.
 * Un `$view` scritto a mano verso un file che non esiste e' un View not found a runtime.
 *
 * Regola: bashscripts/ai/wiki/rules/filament-template-as-dress.md
 */

dataset('widget auth e vista convenzionale', [
    'forgot password' => [ForgotPasswordWidget::class, 'filament.widgets.auth.forgot-password', 'sendResetLink'],
    'reset password' => [ResetPasswordWidget::class, 'filament.widgets.auth.reset-password', 'resetPassword'],
]);

test('il widget auth non dichiara $view', function (string $widget): void {
    Assert::assertTrue(class_exists($widget));

    $declaring = (new ReflectionProperty($widget, 'view'))->getDeclaringClass()->getName();

    Assert::assertNotSame($widget, $declaring);
})->with('widget auth e vista convenzionale');

test('il modulo fornisce la vista convenzionale del widget auth', function (string $widget, string $view): void {
    Assert::assertTrue(view()->exists('user::'.$view), 'Manca la vista user::'.$view.' per '.$widget);
})->with('widget auth e vista convenzionale');

test('il widget auth risolve la vista convenzionale', function (string $widget, string $view): void {
    Assert::assertTrue(class_exists($widget));

    $resolved = (new ReflectionProperty($widget, 'view'))->getValue(new $widget);

    Assert::assertIsString($resolved);
    Assert::assertSame($view, Str::after($resolved, '::'));
    Assert::assertTrue(view()->exists($resolved));
})->with('widget auth e vista convenzionale');

test('il widget auth si renderizza con il form della sua vista', function (string $widget, string $view, string $submit): void {
    Livewire::test($widget)
        ->assertOk()
        ->assertSeeHtml('wire:submit="'.$submit.'"');
})->with('widget auth e vista convenzionale');
