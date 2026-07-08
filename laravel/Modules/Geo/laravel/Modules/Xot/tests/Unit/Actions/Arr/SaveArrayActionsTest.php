<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use Modules\Xot\Actions\Arr\SaveJsonArrayAction;
use Modules\Xot\Actions\Arr\SavePhpArrayAction;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;
use function Safe\tempnam;

it('saves array as php file', function (): void {
    $data = ['foo' => 'bar', 'baz' => 123];
    $filename = tempnam(sys_get_temp_dir(), 'test_save_').'.php';

    $action = app(SavePhpArrayAction::class);
    $result = $action->execute($data, $filename);

    Assert::assertTrue($result);
    Assert::assertTrue(File::exists($filename));
    $savedData = include $filename;
    Assert::assertSame($data, $savedData);
    File::delete($filename);
});

it('saves array as json file', function (): void {
    $data = ['foo' => 'bar', 'baz' => 123];
    $filename = tempnam(sys_get_temp_dir(), 'test_save_').'.json';

    $action = app(SaveJsonArrayAction::class);
    $result = $action->execute($data, $filename);

    Assert::assertTrue($result);
    Assert::assertTrue(File::exists($filename));
    $savedData = json_decode(File::get($filename), true);
    Assert::assertSame($data, $savedData);
    File::delete($filename);
});

it('saves array via SaveArrayAction dispatcher', function (): void {
    $data = ['foo' => 'bar'];
    $filenamePhp = tempnam(sys_get_temp_dir(), 'test_save_dispatch_').'.php';
    $filenameJson = tempnam(sys_get_temp_dir(), 'test_save_dispatch_').'.json';

    $action = app(SaveArrayAction::class);

    Assert::assertTrue($action->execute($data, $filenamePhp, 'php'));
    Assert::assertTrue($action->execute($data, $filenameJson, 'json'));

    File::delete($filenamePhp);
    File::delete($filenameJson);
});
