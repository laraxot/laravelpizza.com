<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use BladeUI\Icons\Factory as IconFactory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Modules\UI\Actions\Icon\GetAllIconsAction;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Registra un set di icone vero su una directory temporanea.
 *
 * L'azione legge la proprietà privata `sets` della factory di blade-icons per reflection e
 * poi cammina il filesystem: mockarla toglierebbe di mezzo esattamente ciò che c'è da
 * verificare. Qui il set è reale, i file SVG sono reali, e si asserisce il risultato.
 *
 * @param  array<int, string>  $relativeFiles
 * @return array{dir: string, prefix: string, set: string}
 */
function uiRegisterProbeIconSet(array $relativeFiles): array
{
    $suffix = bin2hex(random_bytes(4));
    $dir = sys_get_temp_dir().'/ui-icons-probe-'.$suffix;

    foreach ($relativeFiles as $relative) {
        $full = $dir.'/'.$relative;
        File::ensureDirectoryExists(\dirname($full));
        File::put($full, '<svg xmlns="http://www.w3.org/2000/svg"></svg>');
    }

    $set = 'probe-'.$suffix;
    $prefix = 'probe'.$suffix;

    App::make(IconFactory::class)->add($set, ['path' => $dir, 'prefix' => $prefix]);

    return ['dir' => $dir, 'prefix' => $prefix, 'set' => $set];
}

afterEach(function (): void {
    // `File::glob()` non è tipizzata: si restringe qui, senza cast.
    foreach (File::glob(sys_get_temp_dir().'/ui-icons-probe-*') as $dir) {
        if (! \is_string($dir)) {
            continue;
        }

        File::deleteDirectory($dir);
    }
});

it('elenca gli svg del set come icone, con il prefisso del set', function (): void {
    ['prefix' => $prefix, 'set' => $set] = uiRegisterProbeIconSet(['alpha.svg', 'beta.svg']);

    $result = app(GetAllIconsAction::class)->execute();

    Assert::assertArrayHasKey($set, $result);

    $icons = $result[$set]['icons'] ?? null;
    Assert::assertIsArray($icons);
    sort($icons);

    Assert::assertSame([$prefix.'-alpha', $prefix.'-beta'], $icons);
});

it('ignora i file che non sono svg', function (): void {
    ['prefix' => $prefix, 'set' => $set] = uiRegisterProbeIconSet(['solo.svg', 'note.txt', 'immagine.png']);

    $icons = app(GetAllIconsAction::class)->execute()[$set]['icons'] ?? null;

    Assert::assertIsArray($icons);
    Assert::assertSame([$prefix.'-solo'], $icons);
});

it('appiattisce le sottodirectory usando il punto come separatore', function (): void {
    ['prefix' => $prefix, 'set' => $set] = uiRegisterProbeIconSet(['radice.svg', 'gruppo/annidata.svg']);

    $icons = app(GetAllIconsAction::class)->execute()[$set]['icons'] ?? null;

    Assert::assertIsArray($icons);
    sort($icons);

    Assert::assertSame([$prefix.'-gruppo.annidata', $prefix.'-radice'], $icons);
});

it('riporta nel set il proprio nome, oltre alle icone', function (): void {
    ['set' => $set] = uiRegisterProbeIconSet(['unica.svg']);

    $entry = app(GetAllIconsAction::class)->execute()[$set] ?? null;

    Assert::assertIsArray($entry);
    Assert::assertSame($set, $entry['name'] ?? null);
});

it('restituisce un set per ogni set registrato, non solo per la sonda', function (): void {
    ['set' => $set] = uiRegisterProbeIconSet(['unica.svg']);

    $result = app(GetAllIconsAction::class)->execute();

    // La factory ha già i set del progetto: l'azione deve restituirli tutti, non sostituirli.
    Assert::assertGreaterThanOrEqual(1, \count($result));
    Assert::assertArrayHasKey($set, $result);

    foreach (array_keys($result) as $name) {
        Assert::assertIsString($name);
    }
});

it('non cambia risultato al variare del contesto passato', function (): void {
    // `$_context` è dichiarato ma non usato: il test lo fissa, così se un giorno inizierà a
    // contare non passerà inosservato.
    ['set' => $set] = uiRegisterProbeIconSet(['unica.svg']);

    $action = app(GetAllIconsAction::class);

    Assert::assertSame(
        $action->execute('form')[$set]['icons'] ?? null,
        $action->execute('table')[$set]['icons'] ?? null,
    );
});
