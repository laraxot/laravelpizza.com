<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use BladeUI\Icons\Exceptions\SvgNotFound;
use BladeUI\Icons\Factory;
use Modules\Xot\Tests\XotBaseTestCase;
use Nwidart\Modules\Facades\Module;

use function Safe\glob;

// XotBaseTestCase e non TestCase: qui non c'e' database, e le DatabaseTransactions di TestCase
// aprono la transazione su `sqlite` prima che il percorso del file sia impostato.
uses(XotBaseTestCase::class)->group('no-xot-db');

/*
 * Guardia: ogni modulo abilitato con icone in `resources/svg/` ha il suo set Blade Icons, con il
 * nome del modulo in minuscolo come prefisso (`Modules/Tenant/resources/svg/icon.svg` ->
 * `tenant-icon`).
 *
 * Il provider ricavava la cartella da `resources/assets/../svg`: il 2026-11-17 Tenant ha tolto lo
 * scaffold vuoto `resources/assets` e il set `tenant` e' sparito senza errori, finche' `/admin` e'
 * andato in 500 su `tenant-icon`. Story: `docs/stories/blade-icons-set-from-resources-svg.story.md`.
 */
it('resolves an icon from resources/svg of every enabled module, prefixed with the module name', function (): void {
    $factory = app(Factory::class);
    $missing = [];

    foreach (Module::allEnabled() as $module) {
        $icons = array_filter(
            glob($module->getPath().'/resources/svg/*.svg'),
            static fn (mixed $file): bool => \is_string($file) && ! str_contains(pathinfo($file, PATHINFO_FILENAME), '.'),
        );
        $first = reset($icons);
        if (! \is_string($first)) {
            continue;
        }

        $name = $module->getLowerName().'-'.pathinfo($first, PATHINFO_FILENAME);
        try {
            $factory->svg($name);
        } catch (SvgNotFound) {
            $missing[] = $name;
        }
    }

    expect($missing)->toBe([]);
});
