<?php

declare(strict_types=1);

return [
    'name' => 'Cms',
    'icon' => 'cms-icon', // icon on dashboard
    'navigation_sort' => 1,

    /*
     * DCP-283 (C-03): nomi dei middleware che il campo `middleware` del JSON di una pagina puo' dichiarare.
     * Il confronto e' sul nome prima dei due punti (`throttle:10,1` -> `throttle`). Tutto cio' che non e' qui
     * (classi incluse) rende la pagina 503. Per ammettere un middleware si aggiunge qui, non nel JSON.
     * Default = i soli valori usati dai JSON del progetto.
     *
     * @var list<string>
     */
    'page_middleware_allowlist' => ['auth', 'throttle'],

    /*
     * DCP-283 (C-04): contenitori dell'URL (`/{container0}/{slug0}`) per cui `ResolvePageAction` puo' caricare un modello.
     * Mappa contenitore => classe Eloquent. Il modello viene letto con `resolveRouteBinding()` (chiave di rotta e
     * scope del modello) e mostrato solo se la policy `view` lo consente anche a un ospite. Default vuota: `blog` e
     * `events` hanno un ramo proprio (solo contenuti pubblicati) e non passano da qui.
     * L'alias storico `xra.container0_model_map` e' ancora letto con la stessa semantica.
     *
     * @var array<string, class-string<\Illuminate\Database\Eloquent\Model>>
     */
    'container0_models' => [],
];
