<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/patient/referto acceptable', function (): void {
    $res = cmsGet('/it/patient/referto');
});
