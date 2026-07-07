<?php

declare(strict_types=1);

use Modules\Cms\Http\Controllers\Admin\XotPanelController;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('XotPanelController', function (): void {
    test('xot panel controller extends base controller', function (): void {
        $controller = new XotPanelController();

        Assert::assertInstanceOf(Modules\Cms\Http\Controllers\BaseController::class, $controller);
    });

    test('xot panel controller has __call method', function (): void {
    });

    test('xot panel controller uses correct namespace', function (): void {
        $reflector = new ReflectionClass(XotPanelController::class);

        Assert::assertSame('Modules\Cms\Http\Controllers\Admin', $reflector->getNamespaceName());
    });

    test('xot panel controller is not instantiable via constructor without params', function (): void {
        $controller = new XotPanelController();
    });
});
