<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\Mail;

use Modules\Notify\Actions\Mail\GetMailLayoutAction;
use Spatie\QueueableAction\QueueableAction;

describe('GetMailLayoutAction', function () {
    beforeEach(function () {
        $action = new GetMailLayoutAction;
    });

    it('can be instantiated', function () {
        expect($action);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses($action);
        expect($traits)->toContain(QueueableAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts string parameter', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe('string');
    });

    it('execute returns string', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('string');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass($action);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1));');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass($action);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\Mail');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass($action));
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Xot\Actions\Cast\SafeStringCastAction);');
        expect($content)->toContain('use Modules\Xot\Actions\Theme\GetThemeContextAction);');
        expect($content)->toContain('use Modules\Xot\Datas\XotData);');
    });

    it('implements queueable functionality', function () {
        expect(method_exists($action, 'onQueue'));
    });
});
