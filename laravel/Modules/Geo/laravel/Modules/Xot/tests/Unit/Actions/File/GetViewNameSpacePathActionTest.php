<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('gets view namespace path from theme fallback correctly', function (): void {
    $ns = 'pub_theme';
    $themeName = 'TestTheme';

    $xotData = XotData::from(['pub_theme' => $themeName]);

    $reflection = new \ReflectionClass(XotData::class);
    $instanceProperty = $reflection->getProperty('instance');
    $instanceProperty->setAccessible(true);
    $instanceProperty->setValue(null, $xotData);

    $action = app(GetViewNameSpacePathAction::class);
    $result = $action->execute($ns);

    Assert::assertSame(base_path('Themes/'.$themeName), $result);
    $instanceProperty->setValue(null, null);
});
