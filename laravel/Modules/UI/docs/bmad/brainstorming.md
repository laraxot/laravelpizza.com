---
title: "UI: Brainstorming"
type: note
tags: [bmad, ui, brainstorming, decisioni]
created: 2026-09-28
updated: 2026-09-28
status: draft
qmd: "ui   brainstorming ui"
---
title: "UI - Brainstorming"
type: note
tags: [bmad, ui, brainstorming, decisioni]
created: 2026-09-28
bmad_status: active
qmd: "UI brainstorming duplicazioni trait enum Map fallback dati config decisioni aperte"
module: UI
related:
  - ./brainstorming/module-opportunities.md
  - ./architecture.md
  - ./architecture/module-boundary.md
  - ./epics/epic-1-design-system-components.md
  - ./stories/STORY-UI-TABLE-LAYOUT-ENUM-TRANSLATIONS.md
---

# UI: Brainstorming
scope: ui-docs
updated: 2026-10-07
---

# UI - Brainstorming

> **SUMMARY**: il file radice era uno stub (`TODO: brainstorming notes`). Qui si raccoglie l'indice degli shard e le decisioni realmente ancorate ai file del modulo: cinque duplicazioni rilevate con `ls`/`grep` (trait layout, enum layout, fallback Map, `UserData`, config localization) e i file parcheggiati che vanno decisi esplicitamente.

## Shard

- [brainstorming/module-opportunities.md](brainstorming/module-opportunities.md): domande ad alto valore, ipotesi e rischi del modulo

## Decisioni da prendere (evidenza sui file)

### D1: Due implementazioni di `TableLayoutTrait`
- [brainstorming/module-opportunities.md](brainstorming/module-opportunities.md) - domande ad alto valore, ipotesi e rischi del modulo

## Decisioni da prendere (evidenza sui file)

### D1 - Due implementazioni di `TableLayoutTrait`

`app/Traits/TableLayoutTrait.php` e `app/Filament/Actions/Table/TableLayoutTrait.php` espongono entrambe `getTableLayout()`/`setTableLayout()` da sessione, e il contratto `app/Contracts/HasTableLayout.php` è soddisfatto da entrambe. Accanto al primo esiste `app/Traits/TableLayoutTrait.php.bak`.
**Domanda**: quale dei due è il SSoT e l'altro diventa alias? Test di riferimento: `tests/Unit/Traits/HasTableLayoutPageContractTest.php`, `tests/Unit/Enums/TableLayoutEnumTest.php`.

### D2: Due enum per il layout
### D2 - Due enum per il layout

`app/Enums/TableLayout.php` è un enum string con `EnumTrait`; `app/Enums/TableLayoutEnum.php` è un enum Filament che implementa `HasColor`, `HasIcon`, `HasLabel`. Le traduzioni delle label sono tracciate in [stories/STORY-UI-TABLE-LAYOUT-ENUM-TRANSLATIONS.md](stories/story-ui-table-layout-enum-translations.md).
**Domanda**: conversione in enum `HasLabel` o fusione in un unico enum?

### D3: Fallback Map/Geocoding duplicati
### D3 - Fallback Map/Geocoding duplicati

`app/Services/Map/NullMapService.php` e `app/Adapters/Map/NullMapServiceAdapter.php` implementano entrambi `MapServiceContract` con lo stesso docblock *"Fallback quando il modulo Geo non è installato"*; stesso per `NullGeocodingService` e `NullGeocodingServiceAdapter`. Accanto, `app/Filament/Forms/Components/LocationSelector.php.old` e `.to_geo` restano come varianti congelate.
**Domanda**: `Services/Map` resta o si cancella a favore di `Adapters/Map`?

### D4: `UserData` in due directory
### D4 - `UserData` in due directory

`app/Data/UserData.php` e `app/Datas/UserData.php` coesistono (la maggior parte dei data object è in `app/Datas/`: `SliderData`, `SliderDataCollection`, `ThemeMetadataData`).
**Domanda**: directory canonica `Datas` e `app/Data` va ridotta o rimossa?

### D5: Config localization duplicato

`config/laravel-localization.php` e `config/laravellocalization.php` differiscono solo per il nome del file. Quale dei due viene letto dal provider va verificato prima di scegliere il SSoT.

### D6: Widget congelati
### D5 - Config localization duplicato

`config/laravel-localization.php` e `config/laravellocalization.php` differiscono solo per il nome del file. Quale dei due viene letto dal provider va verificato prima di scegliere il SSoT.

### D6 - Widget congelati

In `app/Filament/Widgets/` coesistono `UserCalendarWidget.php` attivo e le varianti `.disabled`, `.disabled2`, `.fila3`. `TestWidget.php` e `TestChartWidget.php` restano in produzione accanto a `app/Filament/Clusters/Test.php` e `app/Filament/Pages/Dashboard.php`.
**Domanda**: i file `.disabled` sono backlog o spazzatura? Lo storico della conversione Livewire → Filament è in [livewire-widget-decision-log.md](livewire-widget-decision-log.md).

## Ipotesi già registrate nel modulo

- Le Action (`app/Actions/`) sono il punto di orchestrazione: `GetAllBlocksAction`, `ResolveLocalizedBlockDataAction`, `GetAllIconsAction`, `GetDaysMappingAction`, `GetUserDataAction`, `Panel/ApplyCalendarToPanelAction`.
- Le Resource Filament sono adattatori: il modulo non ha Resource CRUD proprie, solo `app/Filament/Resources/Pages/BaseListRecords.php`.
- I test esistenti (77 file) sono evidenza parziale: i nomi `UiGapCloser100Test`, `UiRemainingCoverage100Test`, `UiHighestMissCoverageTest` indicano campionamento guidato dal gap, non copertura esaustiva del design system.

## Prossime mosse

1. Risolvere D1–D5 in [epics/epic-1-design-system-components.md](epics/epic-1-design-system-components.md).
2. Aggiornare [architecture.md](architecture.md) quando una duplicazione viene sciolta.
3. Portare ogni decisione chiusa nelle story in `stories/`.
# Brainstorming - Modulo UI

## Idee iniziali

- [IDEA 1]
- [IDEA 2]
- [IDEA 3]

## Problemi da risolvere

- [PROBLEMA 1]
- [PROBLEMA 2]

## Soluzioni proposte

- [SOLUZIONE 1]
- [SOLUZIONE 2]

## Domande aperte

- [DOMANDA 1]
- [DOMANDA 2]
1. Risolvere D1-D5 in [epics/epic-1-design-system-components.md](epics/epic-1-design-system-components.md).
2. Aggiornare [architecture.md](architecture.md) quando una duplicazione viene sciolta.
3. Portare ogni decisione chiusa nelle story in `stories/`.
