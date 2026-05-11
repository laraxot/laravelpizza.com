<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

uses(TestCase::class);

use Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction;
use Modules\Gdpr\Tests\TestCase;

test('HandleRegistrationErrorAction can be instantiated', function () {
    $action = new HandleRegistrationErrorAction();
    expect($action)->toBeInstanceOf(HandleRegistrationErrorAction::class);
});

test('HandleRegistrationErrorAction execute method exists', function () {
    $action = new HandleRegistrationErrorAction();
    expect(method_exists($action, 'execute'))->toBeTrue();
});
