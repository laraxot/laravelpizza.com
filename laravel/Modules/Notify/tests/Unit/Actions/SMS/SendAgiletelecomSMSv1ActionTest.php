<?php

declare(strict_types=1);

use Modules\Notify\Actions\SMS\SendAgiletelecomSMSv1Action;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

describe('SendAgiletelecomSMSv1Action', function () {
    beforeEach(function () {
        $action = new SendAgiletelecomSMSv1Action;
    });

    it('can be instantiated', function () {
        expect($action);
    });

    it('implements SmsActionContract', function () {
        expect($action);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe(SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
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

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\SMS');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass($action));
        $content = file_get_contents($filename);

        expect($content)->toContain('use GuzzleHttp\Client);');
        expect($content)->toContain('use Modules\Notify\Datas\SMS\AgiletelecomData);');
        expect($content)->toContain('use Override);');
    });

    it('does not use QueueableAction trait', function () {
        $traits = class_uses($action);

        expect($traits)->not->toContain('Spatie\QueueableAction\QueueableAction');
    });
});
