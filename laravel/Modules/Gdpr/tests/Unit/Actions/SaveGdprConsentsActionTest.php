<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Actions\SaveGdprConsentsAction;

test('SaveGdprConsentsAction can be instantiated', function () {
    $action = new SaveGdprConsentsAction();
    expect($action)->toBeInstanceOf(SaveGdprConsentsAction::class);
});

test('SaveGdprConsentsAction execute method exists', function () {
    $action = new SaveGdprConsentsAction();
    expect(method_exists($action, 'execute'))->toBeTrue();
});
