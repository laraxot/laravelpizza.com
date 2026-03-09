<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Middleware;

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Http\Middleware\PageSlugMiddleware;

test('PageSlugMiddleware can be instantiated', function () {
    $middleware = new PageSlugMiddleware();

    expect($middleware)->toBeInstanceOf(PageSlugMiddleware::class);
});

test('PageSlugMiddleware handle method exists', function () {
    $middleware = new PageSlugMiddleware();

    expect(method_exists($middleware, 'handle'))->toBeTrue();
});
