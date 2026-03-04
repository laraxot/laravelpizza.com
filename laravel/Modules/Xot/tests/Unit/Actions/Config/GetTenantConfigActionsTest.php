<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Config;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Config\GetTenantConfigArrayAction;
use Modules\Xot\Actions\Config\GetTenantConfigPathAction;
use Tests\TestCase;

uses(TestCase::class);

test('get tenant config actions work', function () {
    $name = 'test_config';
    $path = tempnam(sys_get_temp_dir(), 'test_tenant_config').'.php';
    $data = ['foo' => 'bar'];

    File::put($path, "<?php return ['foo' => 'bar'];");

    $this->mock(GetTenantConfigPathAction::class)
        ->shouldReceive('execute')
        ->with($name)
        ->andReturn($path);

    $action = app(GetTenantConfigArrayAction::class);
    $result = $action->execute($name);

    expect($result)->toBe($data);

    File::delete($path);
});

test('get tenant config array action returns empty if file does not exist', function () {
    $this->mock(GetTenantConfigPathAction::class)
        ->shouldReceive('execute')
        ->andReturn('/non/existent/path.php');

    $action = app(GetTenantConfigArrayAction::class);
    expect($action->execute('invalid'))->toBe([]);
});
