<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Unit\Actions\NotifyTheme;

=======
>>>>>>> 8e583cd (.)
use Modules\Notify\Actions\NotifyTheme\Get;
use Modules\Notify\Datas\NotifyThemeData;
use Spatie\QueueableAction\QueueableAction;

describe('NotifyTheme\Get', function () {
    beforeEach(function () {
        $action = new Get;
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
        expect($method->getNumberOfParameters())->toBe(3);
    });

    it('execute accepts string parameters and array', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe('string');
        expect($params[1]->getType()?->getName())->toBe('string');
        expect($params[2]->getType()?->getName())->toBe('array');
    });

    it('execute returns NotifyThemeData', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe(NotifyThemeData::class);
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

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\NotifyTheme');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass($action));
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Notify\Datas\NotifyThemeData);');
        expect($content)->toContain('use Modules\Notify\Models\NotifyTheme);');
        expect($content)->toContain('use Modules\Xot\Datas\XotData);');
    });

    it('implements queueable functionality', function () {
        expect(method_exists($action, 'onQueue'));
    });
});
