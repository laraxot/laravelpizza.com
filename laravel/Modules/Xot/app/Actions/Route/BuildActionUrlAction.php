<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class BuildActionUrlAction
{
    use QueueableAction;

    /**
     * URL dell'azione `act` sorella della route corrente (`x.items.index` -> `x.items.show`).
     *
     * `row` e' il parametro posizionale opzionale della route-azione (id o model, tipico di `show`/`edit`);
     * `query` si aggiunge ai parametri. Senza route corrente con nome, o se la route-azione non esiste,
     * restituisce l'ancora `#<nome>`.
     *
     * @param  array<string, mixed>  $params
     */
    public function execute(array $params): string
    {
        $action = is_string($params['act'] ?? null) ? $params['act'] : 'show';
        $query = is_array($params['query'] ?? null) ? $params['query'] : [];
        $route = request()->route();
        $routeName = $route instanceof Route ? $route->getName() : null;
        if (! $route instanceof Route || $routeName === null) {
            return '#'.$action;
        }

        // Cambia solo l'ultimo segmento: 'edit' compare anche in 'edit_profile.edit'. Senza punti sostituisce tutto il nome.
        $target = Str::beforeLast($routeName, Str::afterLast($routeName, '.')).$action;
        if (! app(Router::class)->has($target)) {
            return '#'.$target;
        }

        $row = $params['row'] ?? null;

        return route($target, array_merge($route->parameters(), $row === null ? [] : [$row], $query));
    }
}
