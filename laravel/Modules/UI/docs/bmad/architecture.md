---
title: "UI: Architettura BMAD"
type: architecture
tags: [bmad, ui, architecture, design-system]
created: 2026-09-26
updated: 2026-09-28
qmd: "UI architettura mappa reale modelli colonne form azioni provider"
module: UI
related:
  - ./architecture/module-boundary.md
  - ./brainstorming.md
  - ./README.md
  - ./epics/epic-1-design-system-components.md
status: draft
---

# UI: Architettura

> **SUMMARY**: mappa reale del modulo UI: namespace `Modules\UI`, 4 modelli Eloquent senza Resource CRUD, 15 colonne Tabella, 18 campi Form (+1 in `app/Forms`), 14 blocchi, 11 widget Filament, 6 Action, 3 contratti, servizi con fallback `Null*` per Map/Geocoding, 4 provider. Derivata da `find app -type d` e `ls` sui file, non da supposizioni.

## Shard di architettura

- [architecture/module-boundary.md](architecture/module-boundary.md): confini, conteggi, decisioni da confermare, gate

## Namespace e composizione

- Root: `Modules\UI`, alias modulo `ui` (`module.json`).
- Provider dichiarati in `module.json`: `Modules\UI\Providers\UIServiceProvider`, `Modules\UI\Providers\Filament\AdminPanelProvider`.
- Inventario: **121 file PHP in `app/`**, **77 file PHP in `tests/`** (18 in `tests/Feature/`).

## Modelli

`app/Models/`: tutti estendono `Modules\Xot\Models\BaseModel` (i docblock dichiarano esplicitamente l'assenza del modulo FormBuilder).

| Modello | Ruolo | Note |
|---------|-------|------|
| `Category.php` | categorie: `parent_id`, `sort_order`, `is_active`, `slug`, `icon` (tabella `categories`) | factory `Modules\UI\Database\Factories\CategoryFactory`; nessun metodo di relazione, la gerarchia è portata dalla colonna `parent_id` |
| `Collection.php` | contenitori con `name`, `type`, `description` | factory `CollectionFactory` |
| `FieldOption.php` | opzioni dei campi selezione | factory `FieldOptionFactory` |
| `Policies/UiBasePolicy.php` | policy base del modulo | provata da `tests/Fixtures/UiBasePolicyBehaviorConcretePolicy.php` |

Relazioni autoreferenziate: il modello non dichiara metodi `children`/`parent`; l'albero è ricostruito lato UI dai campi `app/Filament/Forms/Components/Children.php` e `ParentSelect.php` sulla colonna `parent_id`.

## Risorse Filament

- `app/Filament/Resources/` contiene **solo** `Pages/BaseListRecords.php`: il modulo non dichiara Resource CRUD proprie.
- `app/Filament/Pages/Dashboard.php`, `app/Filament/Clusters/Test.php`.
- Le Resource di dominio vivono nei moduli consumatori; UI fornisce solo le primitive.

## Primitive UI

### Colonne Tabella (`app/Filament/Tables/Columns/`)

`AddressColumn`, `DummyActionsColumn`, `GroupColumn`, `IconColumn`, `IconStateColumn`, `IconStateGroupColumn`, `IconStateSplitColumn`, `IDColumn`, `OpeningHoursColumn`, `OrderColumn`, `PersonColumn`, `SelectStateColumn`, `SortableIdColumn`, `TimestampColumn`, `TreeColumn`.

### Campi Form

- `app/Filament/Forms/Components/`: `AddressField`, `Children`, `EnumSelect`, `IconPicker`, `InlineDatePicker`, `OpeningHoursField`, `OrderColumn`, `ParentSelect`, `PasswordStrengthField`, `PersonSection`, `RadioBadge`, `RadioCollection`, `RadioIcon`, `RadioImage`, `SelectState`, `TreeField`, `YearSelect`, `Field/QrReader`.
- `app/Forms/Components/RadioCardSelector.php`: selettore a card, fuori dal namespace Filament.
- `app/Filament/Components/SpatieDocumentUpload.php`: upload documenti con Spatie.
- Versioni non attive: `LocationSelector.php.old`, `LocationSelector.php.to_geo`.

### Blocchi e View component

- `app/Filament/Blocks/`: `Category`, `Contact`, `Heading`, `Hero`, `Image`, `ImagesGallery`, `ImageSpatie`, `Navigation`, `Page`, `Paragraph`, `Post`, `Slider`, `Title`, `VideoSpatie`.
- Rendering: `app/View/Components/Render/Block.php` e `Render/Blocks.php`.
- Layout: `BreadLink`, `DarkModeSwitcher`, `Logo`, `Navbar`, `Sidebar`, `Std`, `Svg`, `Page/WithSidebar`, `Blocks/Hero/Simple`.

### Widget Filament (`app/Filament/Widgets/`)

`DarkModeSwitcherWidget`, `GroupWidget`, `HeroWidget`, `OverlookWidget`, `RedirectWidget`, `RowWidget`, `StatWithIconWidget`, `StatsOverviewWidget`, `TestChartWidget`, `TestWidget`, `UserCalendarWidget`. Varianti non attive presenti come file disabilitati: `UserCalendarWidget.php.disabled`, `.disabled2`, `.fila3`.

### Azioni di tabella

`app/Filament/Actions/Header/TableLayoutToggleHeaderAction.php`, `app/Filament/Actions/Table/TableLayoutToggleTableAction.php`, con i trait `Table/TableLayoutTrait.php` e `Table/HasTableLayout.php`.

## Action

| File | Responsabilità |
|------|----------------|
| `app/Actions/Block/GetAllBlocksAction.php` | elenco dei blocchi disponibili |
| `app/Actions/Block/ResolveLocalizedBlockDataAction.php` | dati blocco tradotti |
| `app/Actions/Datetime/GetDaysMappingAction.php` | mapping giorni localizzati |
| `app/Actions/Icon/GetAllIconsAction.php` | catalogo icone |
| `app/Actions/GetUserDataAction.php` | dati utente per la UI |
| `app/Actions/Panel/ApplyCalendarToPanelAction.php` | applica il calendario al pannello (`.disabled` = versione parkata) |

## Contratti, enum, dati, regole

- Contratti: `HasTableLayout` (implementato da `TableLayoutTrait`), `MapServiceContract`, `GeocodingServiceContract`.
- Enum: `CornerPositionEnum`, `FieldTypeEnum`, `TableLayout` (enum string con `EnumTrait`), `TableLayoutEnum` (enum Filament con `HasColor`/`HasIcon`/`HasLabel`).
- Dati: `app/Datas/{SliderData,SliderDataCollection,ThemeMetadataData,UserData}.php` e `app/Data/UserData.php`.
- Regole: `app/Rules/OpeningHoursRule.php` (test `tests/Unit/OpeningHoursRuleTest.php`).

## Servizi e dipendenze

- Nessuna classe applicativa in `app/Services`: gli use case vivono in `app/Actions/`.
- Fallback Map/Geocoding: `app/Adapters/Map/NullMapServiceAdapter.php`, `NullGeocodingServiceAdapter.php`. I docblock li descrivono come *"Fallback quando il modulo Geo non è installato"*.
- Dipendenza da Xot: `XotBaseServiceProvider`, `XotBaseRouteServiceProvider`, `XotBasePanelProvider`, `Xot\Models\BaseModel`, `Xot\Traits\EnumTrait`, `GetModulePathByGeneratorAction` (registrazione Blade component).

## Config, traduzioni, database

- `config/config.php`, `config/laravel-localization.php`, `config/laravellocalization.php` (ultimi due con nome duplicato: rischio di divergenza).
- `resources/lang/it` e `resources/lang/en`: `auth.php`, `blocks.php`, `datepicker.php`, `ui.php`.
- `database/factories/`, `database/migrations/`, `database/seeders/`.

## Test

- `tests/Feature/`: 18 file (colonne, campi, componenti, `UIBusinessLogicTest`, `WidgetBusinessLogicTest`, `DarkModeToggleTest`, `Filament/Widgets/StatsOverviewWidgetTest`).
- `tests/Unit/`: widget (`RowWidgetTest`, `StatWithIconWidgetTest`), enum (`TableLayoutEnumTest`, `UIEnumsCoverageTest`), trait (`Traits/HasTableLayoutPageContractTest`), sicurezza (`Security/BladeXssMitigationsTest`), policy (`UiBasePolicyBehaviorTest`).
- Supporto: `tests/Support/EnsuresUiDatabaseSchema.php` (cfr. story `stories/ensures-ui-database-schema-trait-unused.story.md`).

## Tabella file → responsabilità (sintesi)

| File | Responsabilità |
|------|----------------|
| `app/Providers/UIServiceProvider.php` | bootstrap modulo, registrazione Blade component |
| `app/Providers/Filament/AdminPanelProvider.php` | pannello Filament del modulo |
| `app/Contracts/HasTableLayout.php` | contratto layout tabella |
| `app/Enums/TableLayoutEnum.php` | valori layout supportati da Filament |
| `app/Filament/Tables/Columns/*` | rendering colonne riusabili |
| `app/Filament/Forms/Components/*` | campi form riusabili |
| `app/Filament/Blocks/*` | blocchi di contenuto |
| `app/Services/Map/Null*` e `app/Adapters/Map/Null*` | fallback quando Geo non è installato |
| `app/Models/Category.php` | gerarchia categorie tramite colonna `parent_id` (tabella `categories`) |

## Stato qualità e milestone

- PHPStan: da verificare con `./vendor/bin/phpstan analyse Modules/UI` (non eseguito in questa campagna).
- Pest: da eseguire in ambiente non produzione (host `10.100.200.15` escluso).
- Marker di merge e lock: monitorati dalle story `stories/root-hygiene-conflict-markers.story.md` e `stories/git-status-fleet-merge-markers-ui.story.md`.

## Verifica del 2026-10-14

Confronto di questa mappa con `laravel/Modules/UI`; il testo sopra non e' stato riscritto. Dove diverge, vale questa sezione.

| Affermazione sopra | Stato reale |
|---|---|
| `app/Services/UIService.php`, `ComponentService.php`, `ThemeService.php`, `app/Services/Map/Null*` | residui rimossi; gli use case vivono in Actions e restano gli adapter in `app/Adapters/Map/` |
| `resources/lang/it` e `resources/lang/en` | `resources/lang` non esiste; le traduzioni sono in `lang/` con 11 lingue e `it.json` |
| 15 colonne tabella, 11 widget | 17 colonne (all'elenco mancano `EventColumn` e `OrganizationColumn`), 12 widget (manca `ToastWidget`) |
| 121 file PHP in `app/`, 77 in `tests/` | 123 in `app/`, 81 in `tests/` |
| `LocationSelector.php.old` e `.to_geo` in `Forms/Components` | non ci sono; i file parcheggiati sono `ApplyCalendarToPanelAction.php.disabled`, tre varianti di `UserCalendarWidget.php`, `Http/Kernel.php.no`, `Livewire/Components/Map/InteractiveMap.php.old`, `Traits/TableLayoutTrait.php.bak` |
| PHPStan "non eseguito in questa campagna" | `phpstan analyse Modules/UI` exit 0 il 2026-10-14 |
| Pest "da eseguire in ambiente non produzione" | eseguito con sqlite in memoria: 218 passati, 16 falliti, 1 risky, 109 saltati |

Il frontmatter di questo file ha la chiave `title` ripetuta due volte.
