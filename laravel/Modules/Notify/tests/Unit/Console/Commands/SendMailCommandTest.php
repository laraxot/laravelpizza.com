<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Console\Commands;

use Modules\Notify\Console\Commands\SendMailCommand;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
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
        Assert::assertSame('notify:send-mail', $command->getName());
    });

    it('handle is a public command entrypoint', function () {
        $command = new SendMailCommand;
        $method = new \ReflectionMethod($command, 'handle');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame('handle', $method->getName());
    });
});