<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeBooleanCastAction;

it('casts various values to boolean correctly', function (): void {
    $action = app(SafeBooleanCastAction::class);

    // Booleans
    expect($action->execute(true))->toBeTrue();
    expect($action->execute(false))->toBeFalse();

    // Null
    expect($action->execute(null, true))->toBeTrue();

    // Integers
    expect($action->execute(1))->toBeTrue();
    expect($action->execute(0))->toBeFalse();

    // Floats
    expect($action->execute(1.1))->toBeTrue();
    expect($action->execute(0.0))->toBeFalse();

    // Strings
    expect($action->execute('true'))->toBeTrue();
    expect($action->execute('yes'))->toBeTrue();
    expect($action->execute('false'))->toBeFalse();
    expect($action->execute('no'))->toBeFalse();

    expect($action->execute(''))->toBeFalse();

    // Arrays
    expect($action->execute(['a']))->toBeTrue();
    expect($action->execute([]))->toBeFalse();
});
