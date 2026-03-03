<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Actions\GetViewByClassAction;
use Tests\TestCase;
use Illuminate\Support\Facades\View;

uses(TestCase::class);

test('get view actions work', function () {
    $classAction = app(GetViewByClassAction::class);
    
    // View::fake() allows any view name to be valid
    View::fake();
    
    $view = $classAction->execute('Modules\Xot\Actions\TestViewAction');
    expect($view->getName())->toBe('test-view-action');
});
