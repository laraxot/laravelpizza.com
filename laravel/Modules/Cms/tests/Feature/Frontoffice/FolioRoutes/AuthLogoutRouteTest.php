<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/auth/logout acceptable (may redirect)', function (): void {
    $res = cmsGet('/it/auth/logout');
});
