---
title: Bottoni export coerenti nell'header delle liste e toggle griglia/lista funzionante
status: done
module: Xot (owner), UI, Ptv
created: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../../UI/docs/table-layout-toggle.md
---

# Bottoni export coerenti nell'header delle liste e toggle griglia/lista funzionante

## Fase BMAD

Build (bugfix + UX). Segnalazione utente su
`/progressioni/admin/schedas?filters[anno_valutatore][anno]=2026&filters[ha_diritto][value]=1`.

## Problemi segnalati

1. "Esporta PDF" ed "Esporta Excel (XLS)" si vedono male: piccole icone grigie, non bottoni,
   incoerenti con "Trova esclusi". Chi arriva li' si aspetta un bottone.
2. Il toggle griglia/lista non fa nulla. La griglia esiste per usare le liste dal cellulare.

## Cause, verificate nel codice

### Export

`ExportPdfAction` e `ExportXlsAction` (Xot) usano `->iconButton()`: vista Filament senza
sfondo ne' area cliccabile, solo il glifo grigio. Le altre azioni dello stesso header
(`TrovaEsclusiAction`, `CopyFromLastYearAction`, `PopulateYearAction`, Ptv) usano la vista
bottone di default: quadrato pieno colore primario con icona bianca.

### Toggle griglia/lista

Dalla migrazione "colonne nella `*Table` class" la tabella delle Resource la costruisce
`XotBaseResource::table()` tramite un'istanza di `{Resource}\Tables\*Table` (es.
`SchedasTable`), che usa `HasXotTable` ma **non e' un componente Livewire**:

- `HasXotTable::bootHasXotTable()` legge la preferenza dalla sessione solo se `$this` e' un
  componente Livewire: nella Table class `$layoutView` resta sempre `LIST`.
- `TableLayoutToggleTableAction::toggleLayout()` usciva subito se la pagina (`ListRecords`) non
  usa `HasTableLayoutPage`, e le list page non lo usano: la preferenza non veniva nemmeno
  salvata.
- Dove funzionava chiamava `resetTable()`, che in Filament 5 azzera anche i filtri
  (`resetTableFiltersForm()`): passando a griglia si perdeva "anno 2026".

## Soluzione

| Dove | Cosa | Perche' |
|------|------|---------|
| `Xot/.../Header/ExportPdfAction`, `ExportXlsAction` | vista bottone (tolto `iconButton()`), etichetta nascosta ma presente (`hiddenLabel`, sr-only) e tooltip | stesso aspetto delle azioni accanto, in tutte le liste dell'app; lo screen reader legge "Esporta PDF" |
| `Ptv/.../Header/TrovaEsclusi`, `CopyFromLastYear`, `PopulateYear` | `label('')` sostituito da etichetta tradotta + `hiddenLabel()` | aspetto identico, ma il bottone ha un nome accessibile (prima vuoto) |
| `Xot/.../Traits/HasXotTable::table()` | fuori da Livewire legge il layout dalla sessione | la Table class costruisce la griglia quando l'utente l'ha scelta |
| `UI/.../TableLayoutToggleTableAction` | salva sempre la preferenza; ricostruisce la tabella con `bootedInteractsWithTable()` invece di `resetTable()`; vista bottone grigio | funziona anche con le list page; filtri e ricerca restano; e' un controllo di vista, non un'azione sui dati, quindi neutro |

| `UI/.../TableLayoutToggleTableAction` (seconda parte) | lettura/scrittura del layout sull'istanza (`data_get`, `applyLayoutView()`) invece dei metodi statici del trait | `HasTableLayoutPage::readLayoutFrom()` chiamato sul trait e' deprecato: PHP 8.4 lo segnalava a ogni clic |

## Scelte di design scartate

- **Etichetta visibile sugli export** (`labeledFrom('md')`): piu' chiara su desktop, ma
  l'header avrebbe avuto 2 bottoni con testo e 3 con sola icona. La coerenza richiesta e' con
  Trova esclusi; il nome resta nel tooltip e per lo screen reader.
- **Gruppo "Esporta" a tendina**: header piu' pulito, ma due clic per un'azione frequente.
- **Griglia automatica su cellulare**: il server non conosce la larghezza dello schermo; la
  preferenza resta una scelta dell'utente, ricordata in sessione.

## Verifica

- PHPStan livello 10: 0 errori su tutti i file toccati. Pint ok.
- Tinker in sola lettura, senza leggere record (la lista schede renderizzata farebbe scrivere
  gli accessor `gg_*` in produzione):
  - `SchedasTable` con sessione `list` => `contentGrid` null; con `grid` => `{sm:1, md:2, lg:3,
    xl:4, 2xl:5}`.
  - toggle su `ListSchedas` con filtro anno 2026: sessione `grid`, tabella ricostruita a griglia,
    `tableFilters` invariati; nessun warning di deprecazione.
  - Trova esclusi, Esporta PDF, Esporta Excel: stessa vista `filament::components.button`,
    etichetta nascosta. Toggle: vista bottone, colore `gray`, etichetta "Griglia".
- Effetto collaterale corretto: costruire le azioni da tinker ha fatto scrivere ad
  `AutoLabelAction` tre chiavi grezze in `Lang/lang/it/txt.php` (fallback `lang::txt` fuori da
  una classe `Modules\`). Tolte, file identico a prima.
- Test: `Modules/Progressioni/tests/Feature/Filament/SchedaListLayoutToggleTest.php`.
- Pest saltato: 10.100.200.15 e' produzione. Nessun browser headless disponibile qui:
  verifica visiva da fare nel browser.
