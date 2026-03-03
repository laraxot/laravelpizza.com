<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Arr;

use Modules\Xot\Actions\Arr\SaveArrayAction;
use Tests\TestCase;
use Illuminate\Support\Facades\File;

uses(TestCase::class);

test('save array action saves as php by default', function () {
    $data = ['foo' => 'bar'];
    $filename = tempnam(sys_get_temp_dir(), 'test_save_array_php') . '.php';
    
    $action = app(SaveArrayAction::class);
    $result = $action->execute($data, $filename);
    
    expect($result)->toBeTrue()
        ->and(File::exists($filename))->toBeTrue();
        
    $savedData = include $filename;
    expect($savedData)->toBe($data);
    
    File::delete($filename);
});

test('save array action saves as json', function () {
    $data = ['foo' => 'bar'];
    $filename = tempnam(sys_get_temp_dir(), 'test_save_array_json') . '.json';
    
    $action = app(SaveArrayAction::class);
    $result = $action->execute($data, $filename, 'json');
    
    expect($result)->toBeTrue()
        ->and(File::exists($filename))->toBeTrue();
        
    $savedData = json_decode(File::get($filename), true);
    expect($savedData)->toBe($data);
    
    File::delete($filename);
});

test('save array action throws exception for unsupported format', function () {
    $action = app(SaveArrayAction::class);
    expect(fn() => $action->execute([], 'test.txt', 'txt'))->toThrow(\InvalidArgumentException::class);
});
