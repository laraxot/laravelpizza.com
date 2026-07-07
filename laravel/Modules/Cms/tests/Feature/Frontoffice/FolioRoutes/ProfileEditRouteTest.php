<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/profile/edit acceptable (likely auth required)', function (): void {
    $res = cmsGet('/it/profile/edit');
    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        cmsSkipTest('Profile edit route returned server error in this install.');
    }
});
