<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Illuminate\Support\Facades\View;
use Modules\Cms\Actions\View\GetCmsViewAction;

test('GetCmsViewAction can be instantiated', function () {
    $action = new GetCmsViewAction;

    expect($action)->toBeInstanceOf(GetCmsViewAction::class);
});

test('GetCmsViewAction execute method with existing view', function () {
    // Mock that a view exists
    View::shouldReceive('exists')
        ->with('ui::empty')
        ->andReturn(true);

    $action = new GetCmsViewAction;
    $result = $action->execute('ui::empty');

    expect($result)->toBeString()
        ->and($result)->toBe('ui::empty');
});

test('GetCmsViewAction execute method throws exception for non-existing view', function () {
    // Mock that a view doesn't exist
    View::shouldReceive('exists')
        ->with('non.existing.view')
        ->andReturn(false);

    $action = new GetCmsViewAction;

    expect(fn () => $action->execute('non.existing.view'))->toThrow(Exception::class);
});
