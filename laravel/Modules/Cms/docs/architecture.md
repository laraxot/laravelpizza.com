---
title: "Cms: architettura e flusso di una richiesta"
type: concept
module: Cms
status: active
qmd: "cms architettura folio volt json pagine ResolvePageAction PageSlugMiddleware FolioVoltServiceProvider modelli azioni componenti filament"
---

# Cms: architettura

Il Cms serve le pagine pubbliche **senza controller e senza `web.php`**: le rotte sono file Folio del tema attivo, il
contenuto sono file JSON del tenant, il modulo mette il resolver, il middleware, i componenti Blade e il pannello
Filament per modificarli. Verificato sul codice del modulo (`app/`, `config/`, `routes/`, `resources/views`).

## Flusso di una richiesta pubblica

1. `Http\Middleware\RedirectUnlocalizedPath` (middleware **globale**, aggiunto da `FolioVoltServiceProvider`): un URL
   senza lingua (`/events`) va a `/it/events` solo se la pagina esiste in una cartella Folio montata; altrimenti resta
   404. La decisione e' in `Actions\RedirectUnlocalizedPathAction` (lingua da `Accept-Language`, poi default).
2. `FolioVoltServiceProvider::registerFolioPaths()` registra, per **ogni lingua** di
   `config('laravellocalization.supportedLocales')`, `Folio::path(<pages del tema>)->uri($locale)` e le cartelle
   `resources/views/pages` dei moduli che le hanno. Il tema e' quello di `XotData::getPubThemeViewPath('pages')`
   (chiave `pub_theme` della config del tenant). Middleware: `SetFolioLocale` + `web` + i middleware base del tenant
   + `LaravelLocalizationRoutes`, `LocaleSessionRedirect`, `LaravelLocalizationRedirectFilter`.
3. `SetFolioLocale` imposta la lingua con questa priorita': lingua salvata dell'utente loggato, prefisso dell'URL,
   lingua di default. `localizeFolioNamedRoutes()` fa si' che `route('<nome-folio>')` produca URL con il prefisso lingua.
4. La Blade Folio del tema e' una shell sottile: passa i segmenti della rotta a `<x-page>`
   (`View\Components\Page`). Niente query, `render()` o logica di dominio nelle Blade (vedi
   [adr/cms-owns-page-resolution.md](adr/cms-owns-page-resolution.md)).
5. `Page` chiama `Actions\ResolvePageAction` e ottiene un `Datas\ResolvePageData` (`renderMode`, `item`, `pageSlug`).
6. `Http\Middleware\PageSlugMiddleware` applica il `middleware` dichiarato nel JSON della pagina (es. `["auth"]`);
   `Actions\ValidatePageMiddlewareAction` accetta solo i nomi in `cms.config.page_middleware_allowlist`
   (default `auth`, `guest`, `throttle`; il confronto e' sul nome prima dei due punti); tutto il resto rende la pagina
   503 (fail-closed). Per ammettere un middleware si aggiunge alla config, non al JSON
   ([adr/page-middleware-allowlist.md](adr/page-middleware-allowlist.md)).
   Contratto: [contracts/page-slug-middleware.md](contracts/page-slug-middleware.md).
7. `Page` rende i blocchi (`Models\Traits\HasBlocks` -> `Datas\BlockData`) e, mentre rende, chiama
   `ResolvePageMetaAction::remember()`; `Metatags`/`Head` leggono titolo e descrizione dagli attributi della richiesta
   ([page-title-and-description.md](page-title-and-description.md)).

## Come `ResolvePageAction` sceglie cosa rendere

Dati `(container0, slug0)` della rotta `[container0]/[slug0]`, in ordine:

1. **Modello dinamico.** `blog` e `events` caricano il solo contenuto *pubblicato* tramite il `ThemeComposer` del
   modulo Blog, se installato. Gli altri contenitori solo se elencati in `cms.config.container0_models` (alias storico
   `xra.container0_model_map`); il default e' negato, la mappa nel codice e' vuota (`config/config.php`). Il record e'
   letto con route key e scope globali e mostrato solo se la policy `view` lo consente anche a un ospite: un record non
   autorizzato e' indistinguibile da uno inesistente. Decisione: [adr/container0-model-allowlist.md](adr/container0-model-allowlist.md).
   `renderMode = 'model'`, `pageSlug = "{container0}.view"`.
2. **Pagina CMS con slug esatto** `"{container0}.{slug0}"` (`renderMode = 'cms'`).
3. **Pagina generica del contenitore** `"{container0}.view"`.
4. **Fallback**: `renderMode = 'cms'` con lo slug pieno anche se la pagina non esiste; il "non trovato" lo gestisce il
   rendering. L'Action non lancia eccezioni e non ha effetti collaterali.
   Contratto: [contracts/page-resolution-action.md](contracts/page-resolution-action.md).

Le sotto-pagine (`events/my`, `profile/edit`) seguono la convenzione descritta in
[cms-subpages-folders.md](cms-subpages-folders.md).

## Dati e modelli

| Elemento | Note verificate |
|---|---|
| `Models\Page` | estende `BaseModelLang`, usa `HasBlocks` e `SushiToJsons` (modulo Tenant): le righe vengono dai JSON `database/content/pages/**.json` del tenant. Campi: `slug`, `title` (tradotto), `content_blocks`, `sidebar_blocks`, `footer_blocks`, `middleware`. |
| `Section`, `PageContent` | stesso meccanismo (`database/content/sections`, `database/content/page_contents`); `Section::getBlocksBySlug()` alimenta `<x-section slug>`. |
| `Menu`, `Conf`, `Module`, `Attachment` | modelli di supporto; `AttachmentDiskEnum` per il disco allegati. |
| `Models\Policies\*` | una policy per modello (`PagePolicy`, `SectionPolicy`, `MenuPolicy`, ...) su `CmsBasePolicy`. |
| `Datas\*` | `BlockData`, `ResolvePageData`, `CmsConfigData`, `FooterData`, `HeadernavData`, `LinkData`, `NavbarMenuData`, `ThemeData`, `ThemeMetadataData`. |

Percorso dei file di contenuto: `config/local/<tenant>/database/content/{pages,sections,page_contents}/` (il tenant
deriva dall'`APP_URL`). Schema JSON e regole: [content-json-pages.md](content-json-pages.md).

## Azioni (`app/Actions`)

| Azione | Cosa fa |
|---|---|
| `ResolvePageAction` | sceglie modello o pagina CMS per `[container0]/[slug0]` |
| `ResolvePageMetaAction` | calcola titolo e descrizione e li mette negli attributi della richiesta |
| `ValidatePageMiddlewareAction` | allowlist dei middleware dichiarati nel JSON |
| `RedirectUnlocalizedPathAction` | redirect `/events` -> `/it/events` se la pagina esiste |
| `BuildPageSchemaAction` | JSON-LD della pagina (senza email nel profilo pubblico) |
| `Head\*` | `BuildHeadSchemaAction`, `ComposeDocumentTitleAction`, `ResolveCmsPageAction`, `ResolveHreflangAlternatesAction`, `ResolvePageDescriptionAction`, `ResolveRobotsPolicyAction`, `ResolveWrittenLocalesAction`, `CollapsePathSegmentsAction` |
| `ResolveLocalizedBlockDataAction`, `ResolveBlockQueryAction` | dati localizzati e query dei blocchi |
| `SanitizeHtmlAction` | HTML dei blocchi di testo ripulito prima di `{!! !!}` (via script, stili inline, iframe, `on*`) |
| `SaveFooterConfigAction`, `SaveHeadernavConfigAction` | salvataggio di footer e header nav ([contracts/](contracts/README.md)) |
| `GetStyleClassAction`, `GetViewThemeByViewAction`, `View\GetCmsViewAction` | classi di stile, risoluzione di view del tema, view esistente tipizzata `view-string` |
| `ListInstalledThemesAction` | temi installabili: cartelle di `Themes/` con `resources/views` (usata da `SettingPage`) |
| `Module\FixJigSawByModuleAction` | utilita' di manutenzione dei moduli |

Le Action usano `QueueableAction` (`execute()`); la logica di business non sta in Blade, Livewire o servizi.

## Componenti e viste

`View\Components`: `Page`, `PageContent`, `Section`, `Head`, `Foot`, `Metatags`, `AppLayout`, `GuestLayout`. Viste in
`resources/views/{components,blocks,sections,layouts,filament,livewire,admin}`. Dettaglio in
[components.md](components.md) e [components/page-component-data-contract.md](components/page-component-data-contract.md).

## Pannello Filament

`Providers\Filament\AdminPanelProvider` e `FrontPanelProvider`; risorse `PageResource`, `PageContentResource`,
`SectionResource`, `MenuResource`, `AttachmentResource`; pagine `Dashboard`, `SettingPage`, `Themes`; cluster
`Appearance`; blocchi Builder in `app/Filament/Blocks` e campi in `app/Filament/Fields`. Dettaglio in
[filament-admin.md](filament-admin.md).

## Cosa NON esiste (la documentazione precedente lo dava per presente)

Nel codice non ci sono `PageService`, `BlockService`, `ContentService`, un modello `Block`, `CreatePageAction`,
`PublishPageAction`, `BuildPageAction`, cartelle `Http/Controllers` ne' un `config/local/cms/blocks.php`. I tipi di blocco
sono le classi Builder di `app/Filament/Blocks` e le view del tema; le pagine sono JSON, non righe di database.

## Configurazione del modulo

`config/config.php` (`container0_models`), `config/xra.php` (`pub_theme`, `primary_lang`, `main_module`) e i file di
default UI `badge`, `button`, `fieldset`, `form`, `input`, `navbar`, `panel`, `std`; `phpstan.php` per l'analisi.
