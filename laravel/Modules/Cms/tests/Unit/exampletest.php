<?php

declare(strict_types=1);
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
beforeEach(function (): void {
    cmsSkipTest('Requires admin panel + role seeding not available in minimal Cms test bootstrap.');
});

it('user admin can view main dashboard', function (): void {
});

it('guest user can view main dashboard', function (): void {
});
