---
title: "UI - documentazione del modulo"
type: readme
status: active
updated: 2026-10-14
module: UI
tags: [docs, ui, readme]
qmd: "ui modulo componenti blade filament colonne campi blocchi widget readme quick start"
---
# UI - documentazione

Identita', ownership, quick start e limiti del modulo `Modules\UI`. L'indice operativo `00-INDEX.md` e' stato rimosso il
2026-10-21 (commit `83cc85a8`): per navigare usare [wiki/00-index.md](wiki/00-index.md), [bmad/](bmad/) e [wiki/](wiki/); l'indice
generale del repo e' [docs/README.md](../../../../docs/README.md).

## Identita' e ownership (verificato 2026-10-14)

- Modulo nwidart `UI` (alias `ui`, abilitato: `php artisan module:list`), pacchetto `laraxot/module_ui_fila5`, repo git separato
  `laraxot/module_ui_fila5`. Nessuna versione dichiarata in `module.json` ne' in `composer.json`.
- Scopo: vocabolario visivo condiviso (colonne di tabella, campi di form, blocchi, widget, componenti Blade), senza regole di
  dominio. Dettaglio in [wiki/purpose.md](wiki/purpose.md) e [wiki/scope.md](wiki/scope.md).
- `UIServiceProvider` estende `XotBaseServiceProvider` e registra i Blade component con `GetModulePathByGeneratorAction`;
  `Providers/Filament/AdminPanelProvider` estende `XotBasePanelProvider`. Dipende da Xot (`BaseModel`, provider base, `EnumTrait`).
- Consumatori: importano classi `Modules\UI\` dal proprio `app/` Activity (3 file), Blog (9), Cms (3), Media (2), User (1), Xot (4).

## Cosa contiene (conteggi 2026-10-14)

| Area | Percorso | Contenuto |
|---|---|---|
| Colonne tabella | `app/Filament/Tables/Columns/` | 17 classi: `AddressColumn`, `GroupColumn`, `IconStateColumn`, `OpeningHoursColumn`, `PersonColumn`, `TimestampColumn`... |
| Campi form | `app/Filament/Forms/Components/` | 19 classi piu' `Field/`: `AddressField`, `EnumSelect`, `IconPicker`, `InlineDatePicker`, `OpeningHoursField`, `PasswordStrengthField`...; `app/Forms/Components/RadioCardSelector.php` |
| Blocchi e widget | `app/Filament/Blocks/`, `app/Filament/Widgets/` | 14 blocchi (`Hero`, `Slider`, `Paragraph`...); 12 widget (`StatsOverviewWidget`, `HeroWidget`, `DarkModeSwitcherWidget`...) |
| Blade component | `app/View/Components/`, `resources/views/components/` | `Navbar`, `Sidebar`, `Logo`, `Std`, `Svg`, `BreadLink`, `Render/Block`, `Render/Blocks`, `Page/WithSidebar` |
| Actions | `app/Actions/` | 6: `GetAllBlocksAction`, `ResolveLocalizedBlockDataAction`, `GetDaysMappingAction`, `GetUserDataAction`, `GetAllIconsAction`, `ApplyCalendarToPanelAction` |
| Modelli | `app/Models/` | `Category`, `Collection`, `FieldOption` (piu' `BaseModel` e `Policies/UiBasePolicy`); 3 migration `2026_07_15_*` |
| Contratti e fallback | `app/Contracts/`, `app/Adapters/Map/` | `MapServiceContract`, `GeocodingServiceContract` con adapter `Null*` (il dominio geografico sta in Geo) |
| Traduzioni | `lang/` | 11 lingue (ar, cs, de, en, es, fr, it, nl, pt_BR, pt_PT, ru) e `it.json` |
| Test | `tests/` | 81 file PHP |

`app/Filament/Resources/` contiene solo `Pages/BaseListRecords.php`: UI non ha Resource CRUD. `routes/web.php` e `routes/api.php` sono vuote.
`app/Services` non contiene use case: la logica applicativa vive nelle Queueable Actions, come descritto nella story [services-to-actions-ui](stories/services-to-actions-ui.story.md).

## Quick start

Da `laravel/` (comandi eseguiti il 2026-10-14):

```bash
./vendor/bin/phpstan analyse Modules/UI        # exit 0, nessun errore
APP_CONFIG_CACHE=/nonexistent/config.php DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_DATABASE_LIMESURVEY= \
  ./vendor/bin/pest Modules/UI/tests           # vedi limiti: 16 falliti
```

Per i test usare sempre un database di scratch: con la config cache i test colpiscono il database di sviluppo.

## Limiti noti

- Pest sul modulo: 218 passati, 16 falliti, 1 risky, 109 saltati in 99 s (14 ottobre 2026, sqlite in memoria). 84 dei test saltati
  attendono il database `ui` (tabelle `categories` e `themes`); i 16 falliti sono in `GroupColumnTest`, `OpeningHoursColumnTest`,
  `GetUserDataActionTest`, `UiBasePolicyBehaviorTest`, `UiFilamentComponentsCoverageTest`, `UiGapCloser100Test`,
  `UiRemainingCoverage100Test`. Errori visti: `BindingResolutionException`, `TypeError`, `View [..] not found`. Le cause dei 16
  falliti non sono state indagate: non si sa se siano regressioni del codice o limiti dell'ambiente.
- Il `README.md`, `ARCHITECTURE.md` e `GETTING_STARTED.md` nella radice del modulo (fuori da `docs/`) non sono affidabili:
  il primo contiene marker di merge non risolti, gli altri hanno segnaposto `$MOD`.
- Il `docs/` e' sproporzionato rispetto al codice: 454 file `.md` al 2026-10-23 (294 al 2026-10-14; `_archive/` non esiste
  piu'). Il riordino e' tracciato in [stories/docs-organization-ui.story.md](stories/docs-organization-ui.story.md): spostare file
  solo con una migration map approvata.
- Due file di configurazione quasi omonimi (`config/laravel-localization.php` e `config/laravellocalization.php`).
