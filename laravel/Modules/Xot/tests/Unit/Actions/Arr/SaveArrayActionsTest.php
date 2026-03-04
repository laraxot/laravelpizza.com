<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Arr;

use Modules\Xot\Actions\Arr\SaveArrayAction;
use Modules\Xot\Actions\Arr\SaveJsonArrayAction;
use Modules\Xot\Actions\Arr\SavePhpArrayAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\File;

uses(TestCase::class);

it('saves array as php file', function (): void {
    $data = ['foo' => 'bar', 'baz' => 123];
    $filename = tempnam(sys_get_temp_dir(), 'test_save_') . '.php';
    
    $action = app(SavePhpArrayAction::class);
    $result = $action->execute($data, $filename);
    
    expect($result)->toBeTrue();
    expect(File::exists($filename))->toBeTrue();
    
    $savedData = include $filename;
    expect($savedData)->toBe($data);
    
    File::delete($filename);
});

it('saves array as json file', function (): void {
    $data = ['foo' => 'bar', 'baz' => 123];
    $filename = tempnam(sys_get_temp_dir(), 'test_save_') . '.json';
    
    $action = app(SaveJsonArrayAction::class);
    $result = $action->execute($data, $filename);
    
    expect($result)->toBeTrue();
    expect(File::exists($filename))->toBeTrue();
    
    $savedData = json_decode(File::get($filename), true);
    expect($savedData)->toBe($data);
    
    File::delete($filename);
});

it('saves array via SaveArrayAction dispatcher', function (): void {
    $data = ['foo' => 'bar'];
    $filenamePhp = tempnam(sys_get_temp_dir(), 'test_save_dispatch_') . '.php';
    $filenameJson = tempnam(sys_get_temp_dir(), 'test_save_dispatch_') . '.json';
    
    $action = app(SaveArrayAction::class);
    
    expect($action->execute($data, $filenamePhp, 'php'))->toBeTrue();
    expect($action->execute($data, $filenameJson, 'json'))->toBeTrue();
    
    expect(fn() => $action->execute($data, 'test.txt', 'txt'))->toThrow(\InvalidArgumentException::class);
    
    File::delete($filenamePhp);
    File::delete($filenameJson);
});
