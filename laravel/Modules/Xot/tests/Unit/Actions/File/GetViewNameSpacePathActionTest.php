<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Datas\XotData;

it('gets view namespace path from theme fallback correctly', function (): void {
    $ns = 'pub_theme';
    $themeName = 'TestTheme';

    // Create a concrete instance of XotData
    $xotData = XotData::from(['pub_theme' => $themeName]);

    // Inject it into the singleton instance using reflection
    $reflection = new \ReflectionClass(XotData::class);
    $instanceProperty = $reflection->getProperty('instance');
    $instanceProperty->setAccessible(true);
    $instanceProperty->setValue(null, $xotData);

    $action = app(GetViewNameSpacePathAction::class);
    $result = $action->execute($ns);

    expect($result)->toBe(base_path('Themes/'.$themeName));

    // Reset instance for other tests
    $instanceProperty->setValue(null, null);
});
