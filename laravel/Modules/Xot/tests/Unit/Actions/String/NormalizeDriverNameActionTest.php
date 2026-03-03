<?php

declare(strict_types=1);

use Modules\Xot\Actions\String\NormalizeDriverNameAction;

beforeEach(function (): void {
    $this->action = app(NormalizeDriverNameAction::class);
});

it('normalizes driver name to lowercase', function (): void {
    $result = $this->action->execute('MySQL');
    expect($result)->toBe('mysql');
});

it('removes non-alphanumeric characters', function (): void {
    $result = $this->action->execute('360dialog');
    expect($result)->toBe('360dialog');
});

it('handles driver with special chars', function (): void {
    $result = $this->action->execute('my-driver_v2');
    expect($result)->toBe('mydriverv2');
});
