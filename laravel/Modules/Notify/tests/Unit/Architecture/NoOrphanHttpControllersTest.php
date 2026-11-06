<?php

declare(strict_types=1);
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('does not contain the legacy notification tracking controller', function (): void {
    $controllerPath = dirname(__DIR__, 4)
        .'/app/Http/Controllers/NotificationTrackingController.php';

    Assert::assertFileDoesNotExist($controllerPath);
});