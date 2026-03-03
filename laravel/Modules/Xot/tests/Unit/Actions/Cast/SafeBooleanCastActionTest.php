<?php

declare(strict_types=1);

use Modules\Xot\Actions\Cast\SafeBooleanCastAction;

beforeEach(function (): void {
    $this->action = app(SafeBooleanCastAction::class);
});

it('returns bool as-is', function (): void {
    expect($this->action->execute(true))->toBeTrue();
    expect($this->action->execute(false))->toBeFalse();
});

it('casts null to default', function (): void {
    expect($this->action->execute(null))->toBeFalse();
    expect($this->action->execute(null, true))->toBeTrue();
});

it('casts int to bool', function (): void {
    expect($this->action->execute(1))->toBeTrue();
    expect($this->action->execute(0))->toBeFalse();
});

it('casts float to bool', function (): void {
    expect($this->action->execute(1.5))->toBeTrue();
    expect($this->action->execute(0.0))->toBeFalse();
    expect($this->action->execute(INF, true))->toBeFalse();
});

it('casts string to bool', function (): void {
    expect($this->action->execute('true'))->toBeTrue();
    expect($this->action->execute('yes'))->toBeTrue();
    expect($this->action->execute('false'))->toBeFalse();
    expect($this->action->execute('2'))->toBeTrue();
    expect($this->action->execute('abc', true))->toBeTrue();
});

it('casts array to bool', function (): void {
    expect($this->action->execute([1]))->toBeTrue();
    expect($this->action->execute([]))->toBeFalse();
});

it('casts objects and empty string edge cases', function (): void {
    expect($this->action->execute((object) ['x' => 1]))->toBeTrue()
        ->and($this->action->execute((object) []))->toBeFalse()
        ->and($this->action->execute('   ', true))->toBeTrue();
});

it('executeWithCustomValues uses custom true/false', function (): void {
    $r = $this->action->executeWithCustomValues('custom_yes', ['custom_yes'], ['custom_no']);
    expect($r)->toBeTrue();
    expect($this->action->executeWithCustomValues('custom_no', ['custom_yes'], ['custom_no']))->toBeFalse();
    expect($this->action->executeWithCustomValues('unknown', ['custom_yes'], ['custom_no'], true))->toBeTrue();
});

it('executeWithThreshold compares numeric', function (): void {
    expect($this->action->executeWithThreshold(50, 40, true))->toBeTrue();
    expect($this->action->executeWithThreshold(30, 40, true))->toBeFalse();
    expect($this->action->executeWithThreshold(30, 40, false))->toBeTrue();
    expect($this->action->executeWithThreshold('n/a', 40, false, true))->toBeTrue();
});

it('canCast returns true for castable types', function (): void {
    expect($this->action->canCast(true))->toBeTrue();
    expect($this->action->canCast('x'))->toBeTrue();
});

it('has static cast method', function (): void {
    expect(SafeBooleanCastAction::cast('1'))->toBeTrue();
    expect(SafeBooleanCastAction::castWithCustomValues('yes', ['yes'], ['no']))->toBeTrue();
    expect(SafeBooleanCastAction::castWithThreshold(10, 5))->toBeTrue();
});
