<?php

declare(strict_types=1);

use Modules\Xot\Actions\String\GetPronounceablePasswordAction;

beforeEach(function (): void {
    $this->action = app(GetPronounceablePasswordAction::class);
});

it('generates password with default length', function (): void {
    $result = $this->action->execute();

    expect($result)->toBeString()->not->toBeEmpty();
    expect(strlen($result))->toBeGreaterThanOrEqual(8);
});

it('generates password with custom length', function (): void {
    $result = $this->action->execute(8);

    expect(strlen($result))->toBeGreaterThanOrEqual(6);
});

it('generates different passwords on multiple calls', function (): void {
    $a = $this->action->execute(12);
    $b = $this->action->execute(12);

    expect($a)->not->toBe($b);
});

it('contains uppercase digit and special char', function (): void {
    $result = $this->action->execute(20);
    $hasUpper = 1 === preg_match('/[A-Z]/', $result);
    $hasDigit = 1 === preg_match('/[0-9]/', $result);
    $hasSpecial = 1 === preg_match('/[!#*\-_=+:?]/', $result);

    expect($hasUpper)->toBeTrue()
        ->and($hasDigit)->toBeTrue()
        ->and($hasSpecial)->toBeTrue();
});

it('covers fallback branch for very short requested length', function (): void {
    $result = $this->action->execute(0);
    expect($result)->toBeString()->not->toBeEmpty();
});
