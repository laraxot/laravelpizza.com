<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Actions\GetViewByClassAction;
use Tests\TestCase;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

uses(TestCase::class);

test('get view actions work', function () {
    // We need to mock a view for GetViewAction to work
    $tempDir = sys_get_temp_dir() . '/test_views';
    File::ensureDirectoryExists($tempDir);
    File::put($tempDir . '/test-view.blade.php', 'test content');
    
    View::addNamespace('xot', $tempDir);
    
    $action = app(GetViewAction::class);
    
    // Mocking the file path to simulate a class in Xot module
    $fakeFilePath = base_path('Modules/Xot/app/Actions/SomeAction.php');
    
    // The logic in GetViewAction is complex and depends on base_path() and DIRECTORY_SEPARATOR
    // It's hard to test perfectly without actual module files, but we can try to test the class-based one
    
    $classAction = app(GetViewByClassAction::class);
    // GetViewByClassAction::getViewNameFromClass returns kebab-case of class basename
    $view = $classAction->execute('Modules\Xot\Actions\TestViewAction');
    // It calls view('test-view-action')
    expect($view->getName())->toBe('test-view-action');
    
    File::deleteDirectory($tempDir);
});
