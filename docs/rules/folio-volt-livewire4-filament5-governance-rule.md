# Folio Volt Livewire4 Filament5 Governance Rule

## Scope

Questa regola allinea lo sviluppo al comportamento upstream di:
- `laravel/folio`
- `livewire/volt`
- Livewire `4.x` components
- `filamentphp/filament` `5.x`
- `filamentphp/spatie-laravel-google-fonts-plugin`

## Regole obbligatorie

1. Frontoffice file-based:
   - usare Folio per pagine public (`resources/views/pages`)
   - non introdurre controller/route web classiche per flussi frontoffice gia' coperti da Folio
2. Metadata inline Folio:
   - usare solo helper ufficiali `name()`, `middleware()`, `render()`, `withTrashed()` nel file pagina
   - evitare logica routing duplicata fuori dal perimetro Folio
3. Component strategy:
   - default a Volt single-file component per UI reattiva locale alla pagina
   - usare componenti Livewire multi-file solo se riuso cross-page e' concreto
4. Livewire components:
   - seguire pattern ufficiali di rendering (`<livewire:... />`) e proprietà/azioni tipizzate
   - se serve migrare SFC/MFC, usare `php artisan livewire:convert`
5. Filament 5 stack compatibility:
   - mantenere compatibilita' con Laravel 11+, Livewire 4, PHP 8.2+
   - plugin/pacchetti Filament devono essere compatibili con ramo `5.x`
6. Font policy per pannelli Filament:
   - usare provider Spatie Google Fonts plugin con font cache locale
   - evitare CDN hardcoded quando il provider locale e' disponibile
7. Upgrade discipline:
   - prima di aggiornare Folio, leggere CHANGELOG upstream per fix routing (named routes, nested index, multi-domain overlap)
   - documentare delta tecnico in discussion GitHub prima della rollout

## Definition of Done per modifiche stack

- docs/rules + docs/memory + docs/skills aggiornati
- verifica compatibilita' versioni dichiarata
- discussion GitHub aggiornata con decisioni e impatti
