<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Unit\Console\Commands;

=======
>>>>>>> 8e583cd (.)
use Modules\Notify\Console\Commands\SendMailCommand;

describe('SendMailCommand', function () {
    it('has correct signature', function () {
        $command = new SendMailCommand();

        expect($command->getName())->toBe('notify:send-mail');
    });

    it('has description', function () {
        $command = new SendMailCommand();

        $description = $command->getDescription();

        expect($description)->not->toBeEmpty();
        expect($description)->toBeString();
    });

    it('extends command', function () {
        $command = new SendMailCommand();

        expect($command)->toBeInstanceOf(\Illuminate\Console\Command::class);
    });

    it('has handle method', function () {
        $command = new SendMailCommand();

        expect(method_exists($command, 'handle'))->toBeTrue();
    });
});
