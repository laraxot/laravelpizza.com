<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Modules\Cms\Actions\Module\FixJigSawByModuleAction;
<<<<<<< HEAD
=======
use Modules\Cms\Tests\TestCase;
>>>>>>> laraxot/dev
use Nwidart\Modules\Laravel\Module;
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\SplFileInfo;

use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\unlink;

<<<<<<< HEAD
=======
// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
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
