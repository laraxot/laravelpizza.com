<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeNullableStringCastAction;

it('casts nullable string values consistently', function (): void {
    $action = app(SafeNullableStringCastAction::class);

    expect($action->execute('test'))->toBe('test');
    expect($action->execute(123))->toBe('123');
    expect($action->execute(true))->toBe('1');
    expect($action->execute(null))->toBeNull();
    expect($action->execute([]))->toBeNull();
    expect($action->execute(new \stdClass()))->toBeNull();
});

it('uses static nullable string cast method correctly', function (): void {
    expect(SafeNullableStringCastAction::cast(456))->toBe('456');
    expect(SafeNullableStringCastAction::cast(null))->toBeNull();
});
