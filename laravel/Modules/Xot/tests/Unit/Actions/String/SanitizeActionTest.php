<?php

declare(strict_types=1);

use Modules\Xot\Actions\String\SanitizeAction;

beforeEach(function (): void {
    $this->action = app(SanitizeAction::class);
});

it('strips html tags', function (): void {
    $result = $this->action->execute('<b>bold</b>hello');
    expect($result)->toBe('boldhello');
});

it('decodes html entities', function (): void {
    $result = $this->action->execute('&amp; &lt; &gt;');
    expect($result)->toContain('&')->toContain('<')->toContain('>');
});

it('trims whitespace', function (): void {
    $result = $this->action->execute('  text  ');
    expect($result)->toBe('text');
});
