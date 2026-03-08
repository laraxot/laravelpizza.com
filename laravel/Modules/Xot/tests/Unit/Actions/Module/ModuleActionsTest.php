<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Module;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Module\GetModuleConfigAction;
use Modules\Xot\Actions\Module\GetModuleNameByClassAction;
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;

test('get module name by class action works', function () {
    $action = app(GetModuleNameByClassAction::class);
    expect($action->execute('Modules\User\Models\User'))->toBe('User');
});

test('get module config action works', function () {
    $path = tempnam(sys_get_temp_dir(), 'test_module_config');
    unlink($path);
    mkdir($path);
    File::put($path.'/test.php', "<?php return ['a' => 1]);");

    $this->mock(GetModulePathByGeneratorAction::class
        ->shouldReceive('execute')
        ->with('TestModule', 'config')
        ->andReturn($path);

    $action = app(GetModuleConfigAction::class);
    $result = $action->execute('TestModule', 'test');

    expect($result)->toBe(['a' => 1]);

    File::deleteDirectory($path);
});
