---
title: "Admin Filament da telefono: tabelle senza scroll orizzontale e azioni di riga toccabili"
type: story
status: review
created: 2026-10-28
updated: 2026-10-28
module: UI
story_id: "2026-10-28-mobile-ux-pass"
tags: [docs, ui, xot, filament, mobile, tabelle, bmad]
qmd: "mobile ux pass filament tabelle stackedOnMobile touch target 44px azioni di riga filtri HasXotTable"
related:
  - ../table-layout-toggle.md
  - ../bmad/filament-blueprint.md
  - ../../../Xot/docs/bmad/filament-blueprint.md
---

# Admin Filament da telefono: tabelle senza scroll orizzontale e azioni di riga toccabili

## Richiesta

«studia e migliora la ui/ux da mobile fa tutto con bmad + ecc + second brain + filament blueprint + ponytail».
Ambito di questo passaggio: le impostazioni condivise di `Modules/Xot` (base delle tabelle) e `Modules/UI`. Un punto condiviso
vale per tutti i pannelli (Employee, TechPlanner, User, Cms...), quindi i cambi sono piccoli e con effetto sul solo telefono.

## Studio (cosa offre Filament 5.11 per il mobile)

Letto in `laravel/vendor/filament/**`, non a memoria:

| API | Esito |
|-----|-------|
| `Table::stackedOnMobile()` (`tables/src/Table/Concerns/CanBeStackedOnMobile.php`) | **Usata.** Sotto `sm` (640 px) la riga e' una card con etichetta + valore per cella, ordinamento in un select, "seleziona tutti" in testa. Da `sm` in su CSS identico (`tables/resources/css/table.css`: tutte regole `max-sm:` / `sm:`). |
| `FiltersLayout::AboveContentCollapsible` | Esiste, ma cambia anche il desktop: vedi "Non fatto". |
| `filtersFormColumns(array)` | Accetta breakpoint; un `int` vale solo da `lg` (`schemas/src/Concerns/HasColumns.php`). |
| `Column::visibleFrom()/hiddenFrom()`, `toggleable()` | Per colonna, dipende dal dominio: non si decide nella base. |
| `Action::visibleFrom()` | Non esiste per le azioni (solo per le colonne). |
| `contentGrid`, `Stack`/`Split` | Gia' usati da `TableLayoutEnum` (griglia 1 colonna sotto `md`). |

## Difetti trovati

| # | Difetto (telefono, 360-430 px) | Dove | Stato |
|---|--------------------------------|------|-------|
| 1 | La tabella in lista resta una `<table>`: 5-7 colonne costringono allo scroll orizzontale, il primo schermo non e' leggibile. Il toggle "griglia" esiste ma va scoperto e cambia aspetto a tutti. | `Modules/Xot/app/Filament/Traits/HasXotTable.php:284` (`table()` non chiamava `stackedOnMobile()`); 17 classi usano il trait (list page, `*Table`, relation manager, table widget) | **Corretto** |
| 2 | Le azioni di riga (occhio, matita, cestino) sono icone da 36 px con margine negativo, a 12 px l'una dall'altra: i centri distano 32 px, le aree da 36 px si sovrappongono di 4 px. Bersaglio < 44 px e il cestino accanto alla matita. | `HasXotTable.php:357,364,371` (`->iconButton()`); CSS Filament `support/resources/css/components/icon-button.css` (`size-9`, `-m-2`) e `tables/resources/css/actions.css` (`gap-3`) | **Corretto** (solo sotto 640 px) |
| 3 | I filtri sono sempre aperti sopra la tabella e, sotto `lg`, uno per riga: con 4-6 filtri occupano il primo schermo e il bottone "Applica" (`deferFilters(true)`) sta in fondo. | `HasXotTable.php:586` (`FiltersLayout::AboveContent`), `:190-195` (`int` = solo da `lg`), `:182` | Non fatto (decisione) |
| 4 | Azione di gruppo "elimina" (e "associa") senza etichetta: solo icona, nessun testo e su touch nessun tooltip. | `HasXotTable.php:107` (`AssociateAction ... ->label('')`), `:421` (`DeleteBulkAction ... ->label('')`) | Non fatto (decisione) |
| 5 | Le azioni sono in testa alla card (`RecordActionsPosition::BeforeColumns`), fuori dalla zona del pollice. | `HasXotTable.php:594` | Non fatto (decisione) |
| 6 | Il toggle lista/griglia e il "Nuovo" nell'intestazione sono pulsanti da 36 px (`fi-btn` standard). | `Modules/UI/app/Filament/Actions/Table/TableLayoutToggleTableAction.php:21-24` | Non fatto (vedi sotto) |

## Correzioni

1. **`HasXotTable::table()`** (`Modules/Xot/app/Filament/Traits/HasXotTable.php`, dopo `->striped()`): `->stackedOnMobile()`.
   Una riga, un solo punto. Principi: nessuno scroll orizzontale al primo schermo, una colonna sotto `md`, "seleziona tutti"
   e ordinamento raggiungibili con una mano. La vista a griglia (`contentGrid`) non cambia: il flag riguarda solo il ramo `<table>`.
2. **`Modules/Xot/resources/css/mobile-touch-targets.css`**, registrato in `Modules/Xot/app/Providers/Filament/AdminPanelProvider.php`
   accanto a `header-actions-wrap.css` (stesso canale `FilamentAsset` + `AssetAction`; gli asset Filament sono globali, valgono
   per tutti i pannelli). Sotto 640 px, solo dentro `.fi-ta-table-stacked-on-mobile`: gap azioni 24 px e `::after` di 4 px per
   lato sul pulsante icona (area 44 px, centri a 44 px, nessuna sovrapposizione). Il layout non si sposta. Copia pubblicata in
   `public_html/assets/xot/css/` come per l'altro file (in produzione `AssetAction` non ricopia se la destinazione esiste).
   Nessuna build: e' CSS statico.
3. `Modules/Xot/tests/Unit/HasXotTableTest.php`: `stackedOnMobile` aggiunto alla catena finta di `Table`.

## Non fatto, e perche' (decisioni per l'utente)

- **Filtri comprimibili** (difetto 3): la soluzione di Filament e' `FiltersLayout::AboveContentCollapsible` (bottone "Filtri" con
  contatore dei filtri attivi, pannello chiuso di default). Il layout non conosce il breakpoint, quindi vale anche sul desktop,
  dove oggi i filtri sono sempre visibili: un click in piu' per tutti gli utenti di tutti i moduli. Nessun modulo sovrascrive
  `getTableFiltersLayout()` (grep su `Modules/`). Se si accetta: una riga in `HasXotTable::getTableFiltersLayout()`.
  In alternativa `['sm' => 2, 'lg' => N]` per `filtersFormColumns` (come il default di Filament) migliora solo i tablet.
- **Etichette vuote** (difetto 4): dare un'etichetta (chiave `lang/`) cambia anche il desktop. Va deciso se l'icona nuda e'
  voluta.
- **Posizione azioni** (difetto 5): `AfterColumns` vale anche sul desktop, dove l'azione a sinistra e' una scelta del progetto.
- **Pulsanti dell'intestazione a 44 px** (difetto 6): l'API Filament e' `Size::ExtraLarge`, ma e' per tutti i breakpoint e ingrandisce
  la barra desktop; un CSS ad hoc per ogni pulsante non e' proporzionato al guadagno.
- **Colonne secondarie nascoste su telefono** (`visibleFrom('md')`): dipende dal dominio della singola Resource; la base non sa
  quali colonne siano secondarie. Con `stackedOnMobile()` non e' piu' urgente.
- **Layout predefinito a griglia sui telefoni** (rilevando lo user agent): superato da `stackedOnMobile()`; la preferenza
  resta quella dell'utente (`table_layout_default`, vedi [table-layout-toggle.md](../table-layout-toggle.md)).
- Non toccati: sidebar (su mobile e' gia' un cassetto di Filament), notifiche (gia' a tutta larghezza), form e dashboard
  (`XotBaseDashboard::getColumns()` = 2 vale da `lg`, sotto e' una colonna), `maxContentWidth('full')`.

## Verifica manuale suggerita

Nessun test automatico di resa (serve un browser e un utente reale: i test del repo usano MySQL e qui sono vietati). Accedere al
pannello admin, aprire una lista con 5+ colonne (ad esempio una lista di Employee o TechPlanner), a **360, 390 e 430 px**
(DevTools, modalita' dispositivo):

1. Nessuno scroll orizzontale; ogni riga e' una card con "Etichetta: valore"; in testa il select di ordinamento.
2. Le tre azioni di riga sono separate, ciascuna con area di tocco di 44 px (DevTools, ispeziona `.fi-icon-btn`, vedi `::after`).
3. A **640 px e oltre** la tabella e' quella di prima (colonne, intestazioni, azioni a sinistra): nessuna regressione desktop.
4. Il toggle griglia/lista continua a funzionare e i filtri restano dopo il cambio.
5. Con il tema scuro le card hanno bordo e sfondo leggibili (stili di Filament, non nostri).

## Diario

- 2026-10-28: studio di `vendor/filament/tables` (5.11.0), applicati `stackedOnMobile()` e il CSS di tocco; PHPStan e `php -l`
  puliti sui file toccati.
