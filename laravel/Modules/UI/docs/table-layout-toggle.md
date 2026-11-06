---
title: Toggle griglia/lista delle tabelle, come funziona
type: concept
module: UI
status: active
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
qmd: "table layout toggle griglia lista grid mobile TableLayoutToggleTableAction HasXotTable sessione"
related:
  - ../../Xot/docs/stories/list-header-buttons-and-grid-toggle.story.md
  - ./bugfix-table-layout-action.md
---

# Toggle griglia/lista delle tabelle, come funziona

## Perche' esiste

La vista a griglia (card impilate, `contentGrid` 1 colonna su `sm`) serve a usare le liste dal
cellulare: una tabella con 7 colonne su 360 px costringe allo scroll orizzontale. Il bottone e'
nell'header della tabella, grigio (cambia la vista, non i dati), solo icona con etichetta per
screen reader e tooltip che dice dove porta ("Griglia" / "Lista").

## Flusso

1. Preferenza in sessione: chiave `table_layout_default` (`TableLayoutTrait`). Una sola per
   utente: chi sceglie la griglia sul telefono la ritrova su tutte le liste.
2. Costruzione tabella: `HasXotTable::table()`.
   - Componenti Livewire con `HasTableLayoutPage` (widget, relation manager): `$layoutView`
     letto in `bootHasXotTable()`.
   - `*Table` class delle Resource (es. `SchedasTable`): **non** sono componenti Livewire, quindi
     `table()` legge la sessione direttamente. Prima di 2026-10-28 restavano sempre in lista.
3. Clic: `TableLayoutToggleTableAction::toggleLayout()` salva il nuovo layout, aggiorna
   `layoutView` se il componente lo ha (`applyLayoutView()`), poi ricostruisce la tabella con
   `bootedInteractsWithTable()`.

## Errori da non ripetere

| Errore | Effetto |
|--------|---------|
| Uscire se la pagina non usa `HasTableLayoutPage` | Le list page non lo usano: il toggle non faceva nulla. |
| `resetTable()` per ridisegnare | In Filament 5 azzera anche i filtri: passando a griglia si perdeva l'anno. |
| `HasTableLayoutPage::readLayoutFrom()` chiamato staticamente sul trait | Deprecato da PHP 8.1, warning a runtime in 8.4. Usare l'istanza. |
| Verificare il toggle solo su un widget | Il caso principale sono le list page con `*Table` class. |

## Test

`Modules/Progressioni/tests/Feature/Filament/SchedaListLayoutToggleTest.php` (lista schede:
griglia attiva dopo il toggle, filtri invariati).
