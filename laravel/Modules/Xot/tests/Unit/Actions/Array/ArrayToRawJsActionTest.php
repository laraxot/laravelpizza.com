<?php

declare(strict_types=1);

use Filament\Support\RawJs;
use Modules\Xot\Actions\Array\ArrayToRawJsAction;

beforeEach(function (): void {
    $this->action = app(ArrayToRawJsAction::class);
});

it('converts simple array to RawJs', function (): void {
    $result = $this->action->execute(['a' => 1, 'b' => 2]);
    expect($result)->toBeInstanceOf(RawJs::class);
    expect($result->toHtml())->toContain('a')->toContain('1');
});

it('converts boolean and null', function (): void {
    $result = $this->action->execute(['flag' => true, 'n' => null]);
    expect($result->toHtml())->toContain('true')->toContain('null');
});

it('preserves RawJs values', function (): void {
    $raw = RawJs::make('function(){}');
    $result = $this->action->execute(['fn' => $raw]);
    expect($result->toHtml())->toContain('function');
});

it('handles nested arrays and escaped keys/strings', function (): void {
    $result = $this->action->execute([
        'not-valid-key' => "O'Reilly\\Books",
        'nested' => ['child' => 7],
    ]);

    expect($result->toHtml())
        ->toContain("'not-valid-key'")
        ->toContain("O\\'Reilly\\\\Books")
        ->toContain("nested: {child: 7}");
});
