<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction;

test('HandleSuccessfulRegistrationAction can be instantiated', function () {
    $action = new HandleSuccessfulRegistrationAction();
    expect($action)->toBeInstanceOf(HandleSuccessfulRegistrationAction::class);
});

test('HandleSuccessfulRegistrationAction execute method exists', function () {
    $action = new HandleSuccessfulRegistrationAction();
    expect(method_exists($action, 'execute'))->toBeTrue();
});
