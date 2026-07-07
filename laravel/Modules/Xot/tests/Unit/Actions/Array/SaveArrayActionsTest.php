<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Array\SaveJsonArrayAction;
use Modules\Xot\Actions\Array\SavePhpArrayAction;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;
use function Safe\tempnam;

test('save json array action works', function () {
    $data = ['foo' => 'bar'];
    $filename = tempnam(sys_get_temp_dir(), 'test_json').'.json';

    $action = app(SaveJsonArrayAction::class);
    $result = $action->execute($data, $filename);

    Assert::assertTrue($result);
    $savedData = json_decode(File::get($filename), true);
    Assert::assertSame($data, $savedData);
    File::delete($filename);
});

test('save php array action works', function () {
    $data = ['foo' => 'bar'];
    $filename = tempnam(sys_get_temp_dir(), 'test_php').'.php';

    $action = app(SavePhpArrayAction::class);
    $result = $action->execute($data, $filename);

    Assert::assertTrue($result);
    $savedData = include $filename;
    Assert::assertSame($data, $savedData);
    File::delete($filename);
});
