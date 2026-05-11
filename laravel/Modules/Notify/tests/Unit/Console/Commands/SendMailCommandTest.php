<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Console\Commands\SendMailCommand;

describe('SendMailCommand', function () {
    it('has correct signature', function () {
        $command = new SendMailCommand;

        expect($command->getName())->toBe('notify:send-mail');
    });

    it('has description', function () {
        $command = new SendMailCommand;

        $description = $command->getDescription();

        expect($description)->not->toBeEmpty();
        expect($description)->toBeString();
    });

    it('extends command', function () {
        $command = new SendMailCommand;

        expect($command)->toBeInstanceOf(Command::class);
    });

    it('has handle method', function () {
        $command = new SendMailCommand;

        expect(method_exists($command, 'handle'))->toBeTrue();
    });
});
