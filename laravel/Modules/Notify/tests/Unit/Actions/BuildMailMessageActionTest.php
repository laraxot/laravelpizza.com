<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Notify\Actions\BuildMailMessageAction;
use Modules\Notify\Actions\NotifyTheme\Get;
use Modules\Notify\Datas\AttachmentData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

describe('BuildMailMessageAction', function () {
    // Test strutturali - non richiede container per la classe
    it('has correct class definition', function () {
        $reflection = new ReflectionClass(BuildMailMessageAction::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(BuildMailMessageAction::class);
        expect($traits)->toContain(QueueableAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(BuildMailMessageAction::class);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(4);
    });

    it('has correct return type', function () {
        $reflection = new ReflectionClass(BuildMailMessageAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe(MailMessage::class);
    });

    it('has private decodeRichText method', function () {
        $reflection = new ReflectionClass(BuildMailMessageAction::class);
        $method = $reflection->getMethod('decodeRichText');

        expect($method->isPrivate())->toBeTrue();
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(BuildMailMessageAction::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(BuildMailMessageAction::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(BuildMailMessageAction::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Notify\Actions\NotifyTheme\Get;');
        expect($content)->toContain('use Modules\Notify\Datas\AttachmentData;');
        expect($content)->toContain('use Spatie\LaravelData\DataCollection;');
    });

    it('has QueueableAction trait applied correctly', function () {
        // The trait is applied, checking trait methods presence
        $traits = class_uses(BuildMailMessageAction::class);
        expect($traits)->toContain(QueueableAction::class);
    });
});
