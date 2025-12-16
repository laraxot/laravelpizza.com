<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Illuminate\Support\Facades\View;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;

class GetViewNameSpacePathAction
{
    use QueueableAction;

    /**
     * Ottiene il percorso di un namespace di vista.
     *
     * @param  string  $ns  Il namespace della vista
     * @return string|null Il percorso del namespace o null se non trovato
     */
    public function execute(string $ns): ?string
    {
        $xot = XotData::make();

        // Utilizziamo il facade View direttamente per accedere ai view hints
        $viewFactory = View::getFacadeRoot();
        $viewHints = [];

        // Verifichiamo che viewFactory sia un oggetto e che abbia il metodo getViewFinder
        if (is_object($viewFactory) && method_exists($viewFactory, 'getViewFinder')) {
            $finder = $viewFactory->getViewFinder();

            // Verifichiamo che finder sia un oggetto e che abbia il metodo getHints
            if (is_object($finder) && method_exists($finder, 'getHints')) {
                $viewHints = $finder->getHints();
            }
        }

        // Verifichiamo che $viewHints sia un array e che contenga la chiave $ns
        if (is_array($viewHints) && isset($viewHints[$ns])) {
            $paths = $viewHints[$ns];
            // Verifichiamo che $paths sia un array e che contenga almeno un elemento
            if (is_array($paths) && isset($paths[0]) && is_string($paths[0])) {
                return $paths[0];
            }
        }

        // Se non abbiamo trovato il namespace nelle view hints, proviamo a usare il tema
        $theme_name = $xot->{$ns} ?? null;

        if (! is_string($theme_name)) {
            return null; // Restituiamo null se il tema non è una stringa
        }

        return base_path('Themes/'.$theme_name);
    }
}
