<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

uses(TestCase::class);

use Illuminate\Validation\ValidationException;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Tests\TestCase;

test('ValidateGdprConsentAction passes with valid consents', function () {
    $action = new ValidateGdprConsentAction();

    expect(fn () => $action->execute(true, true))->not->toThrow(ValidationException::class);
});

test('ValidateGdprConsentAction throws with false privacy', function () {
    $action = new ValidateGdprConsentAction();

    expect(fn () => $action->execute(false, true))->toThrow(ValidationException::class);
});

test('ValidateGdprConsentAction throws with false terms', function () {
    $action = new ValidateGdprConsentAction();

    expect(fn () => $action->execute(true, false))->toThrow(ValidationException::class);
});

test('ValidateGdprConsentAction throws with both false', function () {
    $action = new ValidateGdprConsentAction();

    expect(fn () => $action->execute(false, false))->toThrow(ValidationException::class);
});
