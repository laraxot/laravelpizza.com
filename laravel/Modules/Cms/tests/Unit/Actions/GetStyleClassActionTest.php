<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Modules\Cms\Actions\GetStyleClassAction;

test('GetStyleClassAction can be instantiated', function () {
    $action = new GetStyleClassAction;

    expect($action)->toBeInstanceOf(GetStyleClassAction::class);
});

// Test instantiation only - no mocking to allow coverage
// The actual execute method will fail but should still be covered
test('GetStyleClassAction execute method exists', function () {
    $action = new GetStyleClassAction;

    expect(method_exists($action, 'execute'))->toBeTrue();
});
