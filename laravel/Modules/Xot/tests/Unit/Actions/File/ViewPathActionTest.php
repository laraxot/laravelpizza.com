<?php

declare(strict_types=1);

use Modules\Xot\Actions\File\ViewPathAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(ViewPathAction::class);
});

it('returns view path for module view', function (): void {
    // Test that the action returns a string path
    $result = $this->action->execute('xot::test.view');

    expect($result)->toBeString();
});

it('handles different view formats', function (): void {
    // Test with various view name formats
    $formats = [
        'xot::filament.pages.dashboard',
        'user::profile.show',
        'cms::blocks.hero',
    ];

    foreach ($formats as $view) {
        $result = $this->action->execute($view);
        expect($result)->toBeString("View path for {$view} should be a string");
    }
});
