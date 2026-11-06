<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Modules\Cms\Actions\Module\FixJigSawByModuleAction;
use Nwidart\Modules\Laravel\Module;
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\SplFileInfo;

use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\unlink;

test('FixJigSawByModuleAction can be instantiated', function () {
    Assert::assertTrue(class_exists(FixJigSawByModuleAction::class));
});

test('FixJigSawByModuleAction execute method returns array', function () {
    // Mock a module instance
    /** @var Module&MockInterface $module */
    $module = Mockery::mock(Module::class);
    $module->allows([
        'getPath' => '/tmp/test-module',
        'getName' => 'TestModule',
    ]);

    $stubsDir = '/tmp/test-stubs';
    if (! is_dir($stubsDir)) {
        mkdir($stubsDir, 0755, true);
    }

    file_put_contents($stubsDir.'/test.stub', 'This is a test stub for ModuleName');

    // Mock File facade to return our test stub file
    File::shouldReceive('allFiles')
        ->with(Mockery::any())
        ->andReturn([new SplFileInfo($stubsDir.'/test.stub', '', 'test.stub')]);

    $action = new FixJigSawByModuleAction;
    /** @var array<string, mixed> $result */
    $result = $action->execute($module);
    Assert::assertArrayHasKey('files', $result);

    unlink($stubsDir.'/test.stub');
    rmdir($stubsDir);
});
