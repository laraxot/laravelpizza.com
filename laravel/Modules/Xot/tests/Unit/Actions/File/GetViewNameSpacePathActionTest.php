<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\View;
use Modules\Xot\Datas\XotData;

uses(TestCase::class);

it('gets view namespace path from registered hints correctly', function (): void {
    $ns = 'test_ns';
    $path = '/some/view/path';
    View::addNamespace($ns, $path);

    $action = app(GetViewNameSpacePathAction::class);
    $result = $action->execute($ns);

    expect($result)->toBe($path);
});

it('gets view namespace path from theme fallback correctly', function (): void {
    $ns = 'pub_theme';
    $themeName = 'TestTheme';
    
    $xotData = XotData::make();
    $xotData->pub_theme = $themeName;

    $action = app(GetViewNameSpacePathAction::class);
    $result = $action->execute($ns);

    expect($result)->toBe(base_path('Themes/'.$themeName));
});

it('returns null if namespace not found', function (): void {
    $action = app(GetViewNameSpacePathAction::class);
    $result = $action->execute('unknown_ns');

    expect($result)->toBeNull();
});
