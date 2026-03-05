<?php

declare(strict_types=1);

use Modules\Notify\Console\Commands\TelegramWebhook;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

test('telegram webhook command has expected signature and handle returns void', function () {
    $command = new TelegramWebhook();

    expect($command->getName())->toBe('telegram:set-webhook');

    $result = $command->handle();
    expect($result)->toBeNull();
});
