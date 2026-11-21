<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Support\Facades\Process;
use Modules\Xot\Actions\ExecuteComposerDumpAutoloadAction;
use Modules\Xot\Tests\TestCase;

use function Safe\file_get_contents;

uses(TestCase::class)->group('no-xot-db');

/*
 * Guardia d'igiene: i test di copertura invocano execute() su ogni Action. Se composer partisse davvero,
 * riscriverebbe l'autoload di vendor e tutti i test dei moduli lanciati dopo fallirebbero con
 * "TestCase not found". XotBaseTestCase finge solo i comandi composer.
 */
it('never runs a real composer from a test, so the vendor autoload stays intact', function (): void {
    $autoload = base_path('vendor/composer/autoload_psr4.php');
    $before = file_get_contents($autoload);

    $result = app(ExecuteComposerDumpAutoloadAction::class)->execute();

    expect($result['status'])->toBe('completed')
        ->and(file_get_contents($autoload))->toBe($before);
    Process::assertRan('composer dump-autoload');
});
