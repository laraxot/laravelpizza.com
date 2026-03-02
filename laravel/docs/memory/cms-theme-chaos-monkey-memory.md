# Memoria Operativa - CMS Theme Chaos Monkey

## Invarianti da ricordare

- Namespace tema: `pub_theme::` (non `meetup::`).
- Pipeline runtime: Folio page -> `<x-page>` -> `Modules\\Cms\\View\\Components\\Page` -> JSON pages -> block view.
- Fonte contenuti: `config/local/{tenant}/database/content/pages/*.json`.
- Eventi frontend: usare `toBlockArray()` con URL localizzato.

## Breakpoint ad alta probabilita

1. Slug non allineato tra route Folio e pagina JSON.
2. `data.view` non esistente o rinominata.
3. Query blocco con model non risolvibile.
4. Link frontend costruito manualmente senza locale.

## Sequenza minima di diagnosi

1. `php artisan folio:list`
2. Verifica slug pagina/JSON
3. `view()->exists(data.view)`
4. Verifica `data.query` e modello
5. Verifica output `toBlockArray()`
