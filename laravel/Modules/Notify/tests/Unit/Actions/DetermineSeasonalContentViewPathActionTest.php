<?php

declare(strict_types=1);

use Carbon\Carbon;
use Modules\Notify\Actions\DetermineSeasonalContentViewPathAction;
use Spatie\QueueableAction\QueueableAction;

describe('DetermineSeasonalContentViewPathAction', function () {
    beforeEach(function () {
        $this->action = new DetermineSeasonalContentViewPathAction;
    });

    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(DetermineSeasonalContentViewPathAction::class);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses($this->action);
        expect($traits)->toContain(QueueableAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('returns string from execute', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('string');
    });

    it('has private determineViewFileName method', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('determineViewFileName');

        expect($method->isPrivate())->toBeTrue();
    });

    it('has private getEasterDate method', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('getEasterDate');

        expect($method->isPrivate())->toBeTrue();
    });

    it('returns view path with sixteen namespace', function () {
        $result = $this->action->execute('base-content');

        expect($result)->toStartWith('sixteen::emails.');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass($this->action);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass($this->action);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass($this->action))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Carbon\Carbon;');
        expect($content)->toContain('use Spatie\QueueableAction\QueueableAction;');
        expect($content)->toContain('use Webmozart\Assert\Assert;');
    });
});
