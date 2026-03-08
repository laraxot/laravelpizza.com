<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\GetClassNameByPathAction;

it('gets class name from path correctly', function (): void {
    $tempPath = tempnam(sys_get_temp_dir(), 'test_class_').'.php';
    $content = "<?php\n\nnamespace My\\Test\\Namespace;\n\nclass MyTestClass {}\n";
    File::put($tempPath, $content);

    $action = app(GetClassNameByPathAction::class);
    $result = $action->execute($tempPath);

    expect($result)->toBe('My\\Test\\Namespace\\MyTestClass');

    File::delete($tempPath);
});

it('gets class name from path without namespace correctly', function (): void {
    $tempPath = tempnam(sys_get_temp_dir(), 'test_class_no_ns_').'.php';
    $content = "<?php\n\nclass MyNoNsClass {}\n";
    File::put($tempPath, $content);

    $action = app(GetClassNameByPathAction::class);
    $result = $action->execute($tempPath);

    expect($result)->toBe('MyNoNsClass');

    File::delete($tempPath);
});
