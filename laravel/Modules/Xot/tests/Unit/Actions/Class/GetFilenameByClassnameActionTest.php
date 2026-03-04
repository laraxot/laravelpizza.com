<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Class;

use Modules\User\Models\User;
use Modules\Xot\Actions\Class\GetFilenameByClassnameAction;
use Tests\TestCase;

uses(TestCase::class);

test('get filename by classname action works', function () {
    $action = app(GetFilenameByClassnameAction::class);

    // Existing class
    $filename = $action->execute(User::class);
    expect($filename)->toContain('Modules/User/app/Models/User.php');

    // Non-existent class should NOT be tested for output if it throws exception
    // The action throws exception if class_exists is false and it can't find a fallback string.
    // In our case it fails at line 30.

    expect(fn () => $action->execute('Invalid\Class'))->toThrow(\Exception::class);
});
