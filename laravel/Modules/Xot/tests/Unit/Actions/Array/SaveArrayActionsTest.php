<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Array;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Array\SaveJsonArrayAction;
use Modules\Xot\Actions\Array\SavePhpArrayAction;

test('save json array action works', function () {
    $data = ['foo' => 'bar'];
    $filename = tempnam(sys_get_temp_dir(), 'test_json').'.json';

    $action = app(SaveJsonArrayAction::class);
    $result = $action->execute($data, $filename);

    expect($result)->toBeTrue()
        ->and(File::exists($filename))->toBeTrue();

    $savedData = json_decode(File::get($filename), true);
    expect($savedData)->toBe($data);

    File::delete($filename);
});

test('save php array action works', function () {
    $data = ['foo' => 'bar'];
    $filename = tempnam(sys_get_temp_dir(), 'test_php').'.php';

    $action = app(SavePhpArrayAction::class);
    $result = $action->execute($data, $filename);

    expect($result)->toBeTrue()
        ->and(File::exists($filename))->toBeTrue();

    $savedData = include $filename;
    expect($savedData)->toBe($data);

    File::delete($filename);
});
