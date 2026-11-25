<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Exceptions\Handlers\HandlersRepository;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-xot-db');

test('exception handlers are selected by their declared throwable type', function (): void {
    $repository = new HandlersRepository;
    $runtimeHandler = static fn (\RuntimeException $exception): string => $exception->getMessage();
    $logicHandler = static fn (\LogicException $exception): string => $exception->getMessage();
    $repository->addRenderer($runtimeHandler);
    $repository->addRenderer($logicHandler);

    $handlers = $repository->getRenderersByException(new \RuntimeException('boom'));

    expect($handlers)->toHaveCount(1)
        ->and(array_values($handlers)[0])->toBe($runtimeHandler);
});
