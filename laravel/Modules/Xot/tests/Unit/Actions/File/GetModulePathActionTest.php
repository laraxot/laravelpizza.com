<?php

declare(strict_types=1);

use Modules\Xot\Actions\File\GetModulePathAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(GetModulePathAction::class);
});

it('returns module path for existing module', function (): void {
    // Test with Xot module which we know exists
    $path = $this->action->execute('Xot');

    expect($path)->toBeString()
        ->and(str_contains($path, 'Modules'))->toBeTrue();
});

it('handles lowercase module name', function (): void {
    $path = $this->action->execute('xot');

    expect($path)->toBeString()
        ->and(str_contains($path, 'Modules'))->toBeTrue();
});

it('returns fallback path for non-existent module', function (): void {
    $path = $this->action->execute('NonExistentModuleXYZ');

    expect($path)->toBeString()
        ->and(str_contains($path, 'Modules/NonExistentModuleXYZ'))->toBeTrue();
});
