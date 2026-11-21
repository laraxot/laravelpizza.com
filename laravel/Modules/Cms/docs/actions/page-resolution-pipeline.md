---
qmd: "page resolution pipeline"
issues: []
discussions: []
title: "Page Resolution Pipeline — Cms Module"
type: documentation
created: 2026-07-20
updated: 2026-07-20
confidence: high
tags: [folio, actions, page-resolution, cms, schema-org]
related:
  - ../queueable-actions.md
  - ../actions/view/get-cms-view-action.md
---

# Page Resolution Pipeline — Cms Module

Questo modulo non usa `web.php` né `Http\Controllers` per servire pagine pubbliche: le rotte
`[container0]/[slug0]` sono Folio pages nel tema attivo. Le Actions qui documentate sono
i pezzi non ovvi della pipeline che trasforma quei due parametri di rotta in contenuto
renderizzato.

## `ResolvePageAction`

`app/Actions/ResolvePageAction.php`

Data la coppia `(container0, slug0)` di una rotta Folio, decide **cosa** renderizzare,
in ordine di priorità:

1. **Modello dinamico**: prova a caricare un Eloquent model associato al `container0`
   (es. `events` → `Modules\Meetup\Models\Event`). La mappa dei container noti è
   hard-coded (`$knownMappings`) più un fallback via `config('xra.container0_model_map')`
   e infine un tentativo per convenzione (`Modules\{Container}\Models\{Singular}`,
   `App\Models\{Singular}`). Il caso `container0 === 'profile'` ha una risoluzione
   dedicata (`resolvePublicProfileItem`) che prova `User` e poi profili di modulo.
2. **Pagina CMS con slug esatto**: se non c'è un modello dinamico, cerca
   `Page::where('slug', "{container0}.{slug0}")`.
3. **Pagina CMS generica del container**: fallback su `Page::where('slug', "{container0}.view")`.
4. **Fallback finale**: ritorna comunque `renderMode: 'cms'` con lo slug pieno, anche se
   la pagina non esiste — è compito del layer di rendering gestire il "non trovato".

Ritorna un `ResolvePageData` (`renderMode`, `item`, `pageSlug`) — non fa side effect,
non lancia eccezioni per "non trovato". La ricerca del modello (`queryModel`) prova
prima query Eloquent (con e senza scope globali) e poi, come ultima risorsa, una query
diretta sulla tabella via query builder (`newFromBuilder`) — utile per bypassare scope
che altrimenti nasconderebbero il record.

## `BuildPageSchemaAction`

`app/Actions/BuildPageSchemaAction.php`

Costruisce l'array JSON-LD (`schema.org`) per la pagina corrente, a partire da
`MetatagData`, `routeName`, `path` e `routeParameters`. Il tipo di pagina
(`WebPage`, `ProfilePage`, `CollectionPage`, `ItemPage`, `AboutPage`, `ContactPage`)
è dedotto euristicamente da nome-rotta + path (nessuna configurazione esterna).
Per `ProfilePage` arricchisce lo schema con un `mainEntity` di tipo `Person`,
cercando prima uno `User` reale (per id/slug o utente autenticato) e degradando
a un placeholder `Person` con solo `identifier`/`url` se non trovato.

## `ResolveBlockQueryAction`

`app/Actions/ResolveBlockQueryAction.php`

Permette a un blocco CMS (definito in JSON/DB) di dichiarare una query dinamica invece
di dati statici. Configurazione attesa nel blocco: `model`, `scope`/`scopes`, `orderBy`,
`direction`, `limit`, `wrap_in`. Gli scope vengono invocati con `$query->{$scope}()`
dentro un `try/catch(\BadMethodCallException)` — non usa `method_exists()` perché gli
scope Eloquent passano da `__call` e non sono individuabili staticamente. Se il modello
espone `toBlockArray()`, viene usato al posto di `toArray()` per la trasformazione
(permette ai modelli di controllare la forma dei dati esposta ai blocchi).

## `ResolveLocalizedBlockDataAction`

`app/Actions/ResolveLocalizedBlockDataAction.php`

Attraversa ricorsivamente l'array di dati di un blocco e localizza ogni valore stringa
le cui chiavi sono in una whitelist fissa (`url`, `link`, `href`, `action_url`,
`callback_url`, `redirect_url`, `base_url`, `path`) usando
`LaravelLocalization::getLocalizedURL()`. Salta URL assoluti/esterni, ancore (`/#...`)
e URL che hanno già un prefisso di locale. Necessario perché i blocchi CMS sono salvati
come JSON con URL "nudi" (senza prefisso lingua) e il tema li renderizza in contesto
multilingua.

## Note architetturali

- Tutte le Action seguono il pattern `Spatie\QueueableAction`: unico entrypoint
  `execute()`, nessun repository — vedi [queueable-actions.md](../queueable-actions.md).
- Nessuna di queste Action tocca `web.php`: sono chiamate dalle Folio page del tema
  attivo (`Themes/*/resources/views/pages/...`) o da componenti Blade.
