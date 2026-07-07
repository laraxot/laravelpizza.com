<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Console\Commands\SendMailCommand;

use PHPUnit\Framework\Assert;
describe('SendMailCommand', function () {
    it('has correct signature', function () {
        $command = new SendMailCommand;

        Assert::assertSame('notify:send-mail', $command->getName());
    });

    it('has description', function () {
        $command = new SendMailCommand;

        $description = $command->getDescription();

        Assert::assertNotEmpty($description);
    });

    it('extends command', function () {
        $command = new SendMailCommand;

        Assert::assertInstanceOf(Command::class, $command);
    });

    it('has handle method', function () {
        $command = new SendMailCommand;

            });
});
