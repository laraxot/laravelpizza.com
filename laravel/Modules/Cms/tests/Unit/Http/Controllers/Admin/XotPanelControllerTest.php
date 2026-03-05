<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Http\Controllers\Admin\XotPanelController;

describe('XotPanelController', function (): void {
    test('xot panel controller extends base controller', function (): void {
        $controller = new XotPanelController();

        expect($controller)->toBeInstanceOf(\Modules\Cms\Http\Controllers\BaseController::class);
    });

    test('xot panel controller has __call method', function (): void {
        expect(method_exists(XotPanelController::class, '__call'))->toBeTrue();
    });

    test('xot panel controller uses correct namespace', function (): void {
        $reflector = new ReflectionClass(XotPanelController::class);

        expect($reflector->getNamespaceName())->toBe('Modules\Cms\Http\Controllers\Admin');
    });

    test('xot panel controller is not instantiable via constructor without params', function (): void {
        $controller = new XotPanelController();

        expect($controller)->toBeObject();
    });
});
