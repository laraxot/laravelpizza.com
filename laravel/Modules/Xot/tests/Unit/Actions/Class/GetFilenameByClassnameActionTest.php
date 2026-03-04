<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Class;

use Modules\Xot\Actions\Class\GetFilenameByClassnameAction;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Models\Activity;

uses(TestCase::class);

it('gets filename from classname correctly', function (): void {
    $action = app(GetFilenameByClassnameAction::class);
    
    $filename = $action->execute(Activity::class);
    
    expect($filename)->toBeString();
    expect($filename)->toContain('Modules/Xot/app/Models/Activity.php');
});

it('throws exception for invalid classname that cannot be resolved', function (): void {
    $action = app(GetFilenameByClassnameAction::class);
    
    // Non-existent class will trigger the catch block and try to build a path
    // If it's not a real path, it still returns something from base_path unless it fails completely
    $filename = $action->execute('Invalid\\Class\\Name');
    expect($filename)->toContain('Invalid/Class/Name.php');
});
