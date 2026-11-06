<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Modules\Lang\Actions\GetTransPathAction;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Tests\TestCase;

uses(TestCase::class);

/*
 * C-05 (DCP-282): l'auto-writer delle chiavi mancanti scriveva nei file di lingua a runtime anche in produzione, perche' il default era
 * "acceso, tranne sotto test". Un file lang riscritto a meta o con la riga appesa dopo `return [];` rompe il PHP e manda in 500 ogni pagina
 * che lo carica. Ora il default e' acceso solo con APP_ENV=local; l'override `lang.save_missing_translations` (true o false) resta e vince.
 *
 * Il file di destinazione e' sostituito da un percorso temporaneo: nessun test di questo file tocca i file di lingua dell'albero.
 */
beforeEach(function (): void {
    $this->targetDir = sys_get_temp_dir().'/save-trans-default-'.bin2hex(random_bytes(4));
    File::makeDirectory($this->targetDir);
    $this->target = $this->targetDir.'/lang.php';
    $target = $this->target;

    $this->app->instance(GetTransPathAction::class, new class($target) extends GetTransPathAction
    {
        public function __construct(private readonly string $target) {}

        public function execute(string $key): string
        {
            return $this->target;
        }
    });

    $this->originalEnvironment = $this->app['env'];

    // `Config::offsetUnset()` imposta la chiave a null, non la rimuove, e `Config::get()` restituirebbe null invece del default: si toglie davvero.
    $lang = (array) Config::get('lang', []);
    unset($lang['save_missing_translations']);
    Config::set('lang', $lang);
    expect(Config::has('lang.save_missing_translations'))->toBeFalse();
});

afterEach(function (): void {
    $this->app['env'] = $this->originalEnvironment;
    File::deleteDirectory($this->targetDir);
});

function trySavingMissingKey(): void
{
    app(SaveTransAction::class)->execute('lang::lang.chiave_di_prova.label', 'valore');
}

it('does not write in production when nothing is configured', function (): void {
    $this->app['env'] = 'production';

    trySavingMissingKey();

    expect(file_exists($this->target))->toBeFalse();
});

it('does not write in staging either', function (): void {
    $this->app['env'] = 'staging';

    trySavingMissingKey();

    expect(file_exists($this->target))->toBeFalse();
});

it('writes in the local environment when nothing is configured', function (): void {
    $this->app['env'] = 'local';

    trySavingMissingKey();

    expect(file_exists($this->target))->toBeTrue();
    expect(File::getRequire($this->target))->toBe(['chiave_di_prova' => ['label' => 'valore']]);
});

it('does not write under the test environment by default', function (): void {
    expect($this->app['env'])->toBe('testing');

    trySavingMissingKey();

    expect(file_exists($this->target))->toBeFalse();
});

it('lets the configuration switch it on in production', function (): void {
    $this->app['env'] = 'production';
    Config::set('lang.save_missing_translations', true);

    trySavingMissingKey();

    expect(file_exists($this->target))->toBeTrue();
});

it('lets the configuration switch it off in the local environment', function (): void {
    $this->app['env'] = 'local';
    Config::set('lang.save_missing_translations', false);

    trySavingMissingKey();

    expect(file_exists($this->target))->toBeFalse();
});
