<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/auth/register is reachable', function (): void {
    $res = cmsGet('/it/auth/register');
});
