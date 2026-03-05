<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

test('HandleRegistrationErrorAction can be instantiated', function () {
    $action = new HandleRegistrationErrorAction();
    expect($action)->toBeInstanceOf(HandleRegistrationErrorAction::class);
});

test('HandleRegistrationErrorAction execute method exists', function () {
    $action = new HandleRegistrationErrorAction();
    expect(method_exists($action, 'execute'))->toBeTrue();
});
