<?php

declare(strict_types=1);

use Modules\Notify\Actions\NotifyTheme\Attachment\Pdf;
use Modules\Notify\Datas\AttachmentData;
use Spatie\QueueableAction\QueueableAction;

describe('NotifyTheme\Attachment\Pdf', function () {
    beforeEach(function () {
        // @var mixed action = new Pdf;
    });

    it('can be instantiated', function () {
        expect(// @var mixed action;
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(// @var mixed action;
        expect($traits)->toContain(QueueableAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(2);
    });

    it('execute accepts string and array parameters', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe('string');
        expect($params[1]->getType()?->getName())->toBe('array');
    });

    it('execute returns AttachmentData', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe(AttachmentData::class);
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(// @var mixed action;

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\NotifyTheme\Attachment');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(// @var mixed action;
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Notify\Actions\NotifyTheme\Get;');
        expect($content)->toContain('use Modules\Notify\Datas\AttachmentData;');
        expect($content)->toContain('use Modules\Xot\Services\HtmlService;');
    });
});
