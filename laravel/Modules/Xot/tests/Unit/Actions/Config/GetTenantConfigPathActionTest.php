<?php

declare(strict_types=1);

use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Xot\Actions\Config\GetTenantConfigPathAction;

it('delegates to tenant file path action with php filename', function (): void {
    $tenantPathAction = Mockery::mock(GetTenantFilePathAction::class);
    $tenantPathAction->shouldReceive('execute')
        ->once()
        ->with('mail.php')
        ->andReturn('/tmp/tenant/mail.php');

    app()->instance(GetTenantFilePathAction::class, $tenantPathAction);

    $result = app(GetTenantConfigPathAction::class)->execute('mail');

    expect($result)->toBe('/tmp/tenant/mail.php');
});
