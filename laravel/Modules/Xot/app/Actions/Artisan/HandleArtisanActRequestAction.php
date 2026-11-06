<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Modules\Xot\Enums\ArtisanActEnum;
use Spatie\QueueableAction\QueueableAction;

/**
 * Entrypoint unico del parametro legacy `act` (ex `ArtisanService::act()`).
 *
 * Gli act ammessi sono {@see ArtisanActEnum}: un act sconosciuto restituisce stringa vuota.
 * Ogni ramo compone una Action dedicata invece di duplicarne la logica.
 */
class HandleArtisanActRequestAction
{
    use QueueableAction;

    /**
     * @throws FileNotFoundException
     */
    public function execute(string $act): string
    {
        $case = ArtisanActEnum::tryFrom($act);
        if ($case === null) {
            return '';
        }

        $moduleName = Request::input('module', '');
        if (! is_string($moduleName)) {
            $moduleName = '';
        }

        return match ($case) {
            ArtisanActEnum::Migrate => $this->migrate($moduleName),
            ArtisanActEnum::RouteList => $this->run('route:list'),
            ArtisanActEnum::RouteListView => app(ShowArtisanRouteListAction::class)->execute(),
            ArtisanActEnum::RouteCache => $this->run('route:cache'),
            ArtisanActEnum::RouteClear => $this->run('route:clear'),
            ArtisanActEnum::QueueFlush => $this->run('queue:flush'),
            ArtisanActEnum::Optimize => $this->run('optimize'),
            ArtisanActEnum::Clear => $this->clearAll(),
            ArtisanActEnum::ClearCache => $this->run('cache:clear'),
            ArtisanActEnum::ConfigCache => $this->run('config:cache'),
            ArtisanActEnum::ViewClear => $this->run('view:clear'),
            ArtisanActEnum::DebugbarClear => app(ClearArtisanDebugbarFilesAction::class)->execute(),
            ArtisanActEnum::ModuleList => $this->run('module:list'),
            ArtisanActEnum::ModuleDisable => $this->run('module:disable '.$moduleName),
            ArtisanActEnum::ModuleEnable => $this->run('module:enable '.$moduleName),
            ArtisanActEnum::Error, ArtisanActEnum::ErrorShow => app(ShowArtisanErrorLogAction::class)->execute()->render(),
            ArtisanActEnum::ErrorClear => app(ClearArtisanErrorLogAction::class)->execute(),
        };
    }

    private function migrate(string $moduleName): string
    {
        // Il migrate gira sulla connessione di default: e' quella da rinfrescare (non 'mysql' fisso).
        $defaultConnection = Config::get('database.default');
        $connection = is_string($defaultConnection) && $defaultConnection !== '' ? $defaultConnection : 'mysql';
        DB::purge($connection);
        DB::reconnect($connection);

        if ($moduleName !== '') {
            echo '<h3>Module '.$moduleName.'</h3>';

            // Dati sacri: mai --force (solo migrate additivo)
            return $this->run('module:migrate', ['module' => $moduleName]);
        }

        return $this->run('migrate');
    }

    private function clearAll(): string
    {
        $output = '';
        foreach (['cache:clear', 'config:clear', 'event:clear', 'route:clear', 'view:clear', 'debugbar:clear', 'opcache:clear', 'optimize:clear', 'key:generate'] as $command) {
            $output .= $this->run($command).PHP_EOL;
        }
        $output .= app(ClearArtisanSessionFilesAction::class)->execute().PHP_EOL;
        $output .= app(ClearArtisanErrorLogAction::class)->execute().PHP_EOL;
        $output .= app(ClearArtisanDebugbarFilesAction::class)->execute().PHP_EOL;
        $output .= PHP_EOL.'DONE'.PHP_EOL;

        return $output;
    }

    /**
     * @param  array<string, string>  $arguments
     */
    private function run(string $command, array $arguments = []): string
    {
        return app(RunArtisanCommandAction::class)->execute($command, $arguments);
    }
}
