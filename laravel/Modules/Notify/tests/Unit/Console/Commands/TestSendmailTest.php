<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Console\Commands;

use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\PendingCommand;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @param  array<string, string>  $parameters
 */
function runTestSendmail(TestCase $test, array $parameters): PendingCommand
{
    $pending = $test->artisan('notify:test-sendmail', $parameters);
    Assert::assertInstanceOf(PendingCommand::class, $pending);

    return $pending;
}

describe('notify:test-sendmail', function () {
    it('sends through the requested mailer', function () {
        Mail::fake();

        runTestSendmail($this, ['to' => 'someone@example.com', '--mailer' => 'array'])
            ->assertSuccessful();
    });

    it('rejects an invalid address', function () {
        runTestSendmail($this, ['to' => 'not-an-email'])
            ->assertExitCode(2);
    });

    it('rejects an unknown mailer', function () {
        runTestSendmail($this, ['to' => 'someone@example.com', '--mailer' => 'does-not-exist'])
            ->assertExitCode(2);
    });

    it('reports failure instead of success when the transport throws', function () {
        config(['mail.mailers.broken' => ['transport' => 'smtp', 'host' => '127.0.0.1', 'port' => 1, 'timeout' => 1]]);

        runTestSendmail($this, ['to' => 'someone@example.com', '--mailer' => 'broken'])
            ->assertFailed();
    });
});
