# Xot module overview

## Scopo ("perché esiste")

Il modulo `Xot` è il **foundation module** del framework Laraxot.

In pratica:

- Centralizza **convenzioni** e **comportamenti** per tutti i moduli.
- Fornisce le **XotBase\*** classes (Filament/Laravel wrappers) che i moduli devono estendere.
- Fornisce un set di **Actions** (preferite ai Service tradizionali) e utilities condivise.
- Automatizza la registrazione di views/translations/migrations/components tramite provider base.

## Entry points (boot e registrazione)

- `Modules/Xot/module.json`
  - Provider: `Modules\\Xot\\Providers\\XotServiceProvider`
  - Provider Filament panel: `Modules\\Xot\\Providers\\Filament\\AdminPanelProvider`

### Provider principali

- `Modules\\Xot\\Providers\\XotServiceProvider`
  - Estende `XotBaseServiceProvider`.
  - Nel `boot()` applica policy cross-cutting:
    - redirect SSL (se configurato)
    - view composers
    - eventi
    - timezone + locale
    - macro/configureUsing Filament
    - registrazioni Livewire/Providers

- `Modules\\Xot\\Providers\\XotBaseServiceProvider`
  - È **la base** che gli altri moduli estendono (i provider dei moduli applicativi devono estenderla).
  - Automatizza:
    - `loadTranslationsFrom()` + json translations
    - `loadViewsFrom()`
    - `loadMigrationsFrom()`
    - registrazione componenti Livewire
    - registrazione Blade components
    - registrazione commands
    - registrazione Blade icons (Blade UI Icons)

- `Modules\\Xot\\Providers\\XotBaseRouteServiceProvider`
  - Base per i route provider dei moduli.

## Filament: layer di astrazione (XotBase*)

Xot fornisce wrapper per evitare estensioni dirette di Filament e mantenere comportamento uniforme.

Esempi chiave (non esaustivi):

- Resources:
  - `Modules\\Xot\\Filament\\Resources\\XotBaseResource`
    - `getModel()` dedotto per convenzione se non specificato
    - `getPages()` auto-generato (List/Create/Edit + View se esiste)
    - `getRelations()` autodiscovery in `RelationManagers/*RelationManager.php`
    - `getNavigationBadge()` via `CountAction`

- Pages:
  - `Modules\\Xot\\Filament\\Pages\\XotBasePage`
    - deduzione `getModuleName()` dal namespace
    - deduzione `getModel()` se non specificato
    - schema form con `statePath('data')`
    - view resolution via `GetViewByClassAction`

- Widgets:
  - `Modules\\Xot\\Filament\\Widgets\\XotBaseWidget`
    - integra Forms + Actions
    - richiede implementazione `getFormSchema()`

- Relation managers:
  - `Modules\\Xot\\Filament\\Resources\\RelationManagers\\XotBaseRelationManager`

## Invarianti (politica / religione / zen)

- **DRY + KISS**: la logica comune vive in Xot, i moduli applicativi non la duplicano.
- **Convention over configuration**: molte scelte sono dedotte da naming/namespace (model, translations, pages, relations).
- **XotBase first**: i moduli devono estendere le classi base Xot, non Filament/Laravel direttamente.
- **Traduzioni centralizzate**: evitare stringhe hardcoded; preferire risoluzione tramite provider/trait di traduzione.
- **Actions > Services**: quando possibile usare Actions (queueable/testabili) invece di servizi monolitici.

## Documentazione esistente (come orientarsi)

- `README.md` (indice ad alto livello)
- `FILOSOFIA_MODULO_XOT.md` (filosofia/politica/dogmi, generato 2025-12-24)
- `filament/` e `consolidated/` (guide dettagliate)

## Da migliorare (DRY + KISS)

- **Consolidamento docs**: in `docs/` ci sono molti duplicati e varianti (es. `_1`, file in `archive/`, ecc.). Serve una politica di consolidamento e deprecazione dei duplicati.
- **Ridurre dipendenze cross-module in classi base**: `XotBaseResource` importa `Modules\\Media\\Actions\\GetAttachmentsSchemaAction` (coupling). Valutare inversione di dipendenza o fallback opzionale.
- **Normalizzare naming e link**: garantire link relativi e file docs in lowercase (tranne `README.md`).
- **Testing**: migrazione sistematica dei test legacy a Pest (e evitare mega-classi con troppi metodi pubblici).
- **Regole Filament v4**: verificare che le classi base e i macro/commenti “temporarily disabled” siano allineati con la versione Filament corrente.
