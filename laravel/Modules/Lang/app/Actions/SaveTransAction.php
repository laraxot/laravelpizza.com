<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;

class SaveTransAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed>|int|string|Htmlable|null $data
     */
    public function execute(string $key, int|string|array|Htmlable|null $data): void
    {
        // Scrivere la chiave mancante aiuta chi sviluppa e rovina i test: la suite
        // passa su migliaia di etichette e riscriverebbe i file di lingua dell'albero
        // di lavoro, lasciando in `git status` modifiche che nessuno ha fatto a mano.
        //
        // Il default e' "acceso solo in ambiente locale" (C-05, DCP-282): in produzione un file
        // di lingua riscritto a runtime puo' restare a meta o con la riga appesa dopo `return [];`,
        // e un file con errore di sintassi manda in 500 ogni pagina che lo carica. Sotto test
        // l'ambiente e' `testing`, quindi resta spento. L'override `lang.save_missing_translations`
        // (true o false) vince sempre; la config del modulo non e' caricata con questo nome, quindi
        // un default preso solo da li' sarebbe rimasto acceso proprio dove serve spento.
        if (true !== Config::get('lang.save_missing_translations', app()->isLocal())) {
            return;
        }

        $cont = [];

        $filename = app(GetTransPathAction::class)->execute($key);

        if (! File::exists($filename)) {
            app(SaveArrayAction::class)->execute(
                data: $cont,
                filename: $filename,
            );
        }

        try {
            $cont = File::getRequire($filename);
        } catch (\Exception $e) {
            // File di lingua illeggibile: segnalarlo e non riscriverlo, altrimenti
            // il salvataggio sotto lo sostituirebbe con la sola chiave nuova.
            report($e);

            return;
        }

        if (! is_array($cont)) {
            $cont = [];
        }

        $piece = implode('.', array_slice(explode('.', $key), 1));
        if ('' !== $piece) {
            Arr::set($cont, $piece, $data);
        } else {
            $cont = $data;
        }

        if (! is_array($cont)) {
            throw new \Exception('Error in SaveTransAction');
        }

        /** @var array<string, mixed> $saveData */
        $saveData = $cont;

        app(SaveArrayAction::class)->execute(
            data: $saveData,
            filename: $filename,
        );
    }
}
