<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

uses(TestCase::class);

use Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction;
use Modules\Gdpr\Tests\TestCase;

test('HandleSuccessfulRegistrationAction can be instantiated', function () {
    $action = new HandleSuccessfulRegistrationAction();
    expect($action)->toBeInstanceOf(HandleSuccessfulRegistrationAction::class);
});

test('HandleSuccessfulRegistrationAction execute method exists', function () {
    $action = new HandleSuccessfulRegistrationAction();
    expect(method_exists($action, 'execute'))->toBeTrue();
});
