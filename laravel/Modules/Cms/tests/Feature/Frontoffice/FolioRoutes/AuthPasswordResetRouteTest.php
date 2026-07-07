<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/auth/password/reset acceptable', function (): void {
    $res = cmsGet('/it/auth/password/reset');
});
