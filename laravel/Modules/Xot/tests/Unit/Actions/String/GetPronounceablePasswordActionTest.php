<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\String;

use Modules\Xot\Actions\String\GetPronounceablePasswordAction;

it('generates pronounceable password correctly', function (): void {
    $action = app(GetPronounceablePasswordAction::class);

    $password = $action->execute(12);

    expect(strlen($password))->toBeGreaterThanOrEqual(8); // min length logic inside
    expect($password)->toMatch('/[0-9]/'); // contains digit
    expect($password)->toMatch('/[!#*-_=+:?]/'); // contains special
    expect($password)->toMatch('/[A-Z]/'); // contains uppercase
});

it('handles small length correctly', function (): void {
    $action = app(GetPronounceablePasswordAction::class);
    $password = $action->execute(2);
    expect(strlen($password))->toBeGreaterThanOrEqual(4);
});
