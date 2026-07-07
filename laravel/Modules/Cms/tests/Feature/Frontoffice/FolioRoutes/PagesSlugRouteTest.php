<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

/* @phpstan-ignore method.internalClass */
it('SKIP dynamic /it/{slug}', function (): void {
})->skip('Dynamic pages slug requires fixture.');
