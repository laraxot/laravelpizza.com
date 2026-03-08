<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeStringCastAction;


it('casts various values to string correctly', function (): void {
    $action = app(SafeStringCastAction::class);

    expect($action->execute('test'))->toBe('test');
    expect($action->execute(null))->toBe('');
    expect($action->execute(true))->toBe('1');
    expect($action->execute(false))->toBe('0');
    expect($action->execute(123))->toBe('123');
    expect($action->execute(1.23))->toBe('1.23');

    // Non-scalar
    expect($action->execute(['a']))->toBe('');
    expect($action->execute(new \stdClass()))->toBe('');
});

it('uses static string cast method correctly', function (): void {
    expect(SafeStringCastAction::cast(456))->toBe('456');
});
