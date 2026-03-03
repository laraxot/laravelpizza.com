<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Class;

use Modules\Xot\Actions\Class\GetFilenameByClassnameAction;
use Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('get filename by classname action works', function () {
    $action = app(GetFilenameByClassnameAction::class);
    
    // Existing class
    $filename = $action->execute(User::class);
    expect($filename)->toContain('Modules/User/app/Models/User.php');
    
    // Non-existent class should fallback
    $filename2 = $action->execute('Modules\NonExistent\Test');
    expect($filename2)->toContain('Modules/NonExistent/Test.php');
});
