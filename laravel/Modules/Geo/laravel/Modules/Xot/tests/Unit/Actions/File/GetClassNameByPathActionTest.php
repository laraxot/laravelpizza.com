<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\GetClassNameByPathAction;
use PHPUnit\Framework\Assert;

use function Safe\tempnam;

it('gets class name from path correctly', function (): void {
    $tempFile = tempnam(sys_get_temp_dir(), 'test_class_');
    $tempPath = $tempFile.'.php';
    $content = "<?php\n\nnamespace My\\Test\\Namespace;
\n\nclass MyTestClass {}\n";
    File::put($tempPath, $content);

    $action = app(GetClassNameByPathAction::class);
    $result = $action->execute($tempPath);

    Assert::assertSame('My\\Test\\Namespace\\MyTestClass', $result);
    File::delete($tempPath);
});

it('gets class name from path without namespace correctly', function (): void {
    $tempFile = tempnam(sys_get_temp_dir(), 'test_class_no_ns_');
    $tempPath = $tempFile.'.php';
    $content = "<?php\n\nclass MyNoNsClass {}\n";
    File::put($tempPath, $content);

    $action = app(GetClassNameByPathAction::class);
    $result = $action->execute($tempPath);

    Assert::assertSame('MyNoNsClass', $result);
    File::delete($tempPath);
});
