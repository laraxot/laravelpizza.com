<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Filament\GenerateFormByFileAction;
use Modules\Xot\Actions\Filament\GenerateTableColumnsByFileAction;
use Modules\Xot\Console\Commands\OptimizeFilamentMemoryCommand;
use Modules\Xot\Tests\TestCase;
use Symfony\Component\Finder\SplFileInfo;

uses(TestCase::class)->group('no-xot-db');

test('memory optimization command exposes safe analysis flags', function (): void {
    $command = app(OptimizeFilamentMemoryCommand::class);
    $definition = $command->getDefinition();

    expect($command->getName())->toBe('filament:optimize-memory')
        ->and($definition->hasOption('analyze'))->toBeTrue()
        ->and($definition->hasOption('clear-cache'))->toBeTrue()
        ->and($definition->hasOption('verbose'))->toBeTrue();
});

test('Filament generators leave unsupported files unchanged', function (): void {
    $directory = sys_get_temp_dir().'/xot-generator-contract-'.uniqid('', true);
    File::ensureDirectoryExists($directory);
    $path = $directory.'/resource.txt';
    File::put($path, 'unchanged');
    $file = new SplFileInfo($path, '', 'resource.txt');

    expect((new GenerateFormByFileAction)->execute($file))->toBe(0);
    (new GenerateTableColumnsByFileAction)->execute($file);

    expect(File::get($path))->toBe('unchanged');

    File::deleteDirectory($directory);
});
