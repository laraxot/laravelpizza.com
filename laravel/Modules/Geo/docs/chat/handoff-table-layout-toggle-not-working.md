# Handoff: Cambia layout non funziona

**Stato**: fix in corso nel monorepo · issue GitHub da aprire (gh non disponibile su host agente)

## Problema

Il bottone **Cambia layout** sulle liste `HasXotTable` non alternava lista/griglia: scriveva solo in sessione senza aggiornare `$layoutView` Livewire usato da `HasXotTable::table()`.

## Documentazione

| Percorso | Contenuto |
|----------|-----------|
| [UI bugfix](../laravel/Modules/UI/docs/bugfix-table-layout-toggle-not-working.md) | Causa, contratto, verifica |
| [Xot contratto](../laravel/Modules/Xot/docs/filament/table-layout-toggle-contract.md) | Responsabilità moduli |
| [UI action](../laravel/Modules/UI/docs/actions/table-layout-toggle.md) | Utilizzo azione |

## Codice toccato

- `Modules/UI/app/Filament/Actions/Table/TableLayoutToggleTableAction.php`
- `Modules/UI/app/Filament/Actions/Table/TableLayoutTrait.php`
- `Modules/UI/app/Filament/Traits/HasTableLayoutPage.php` (nuovo)
- `Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`
- `Modules/Xot/app/Filament/Traits/TransTrait.php` (fix `transClass` icona — turno precedente)
- `Modules/UI/lang/it/table_layout_enum.php` (struttura `values`)

## GitHub — comandi da eseguire

`gh` non installato su questo host. Eseguire da macchina con CLI:

### Monorepo (audit trail obbligatorio)

```bash
gh issue create --repo provtv/base_ptv_fila5_mono \
  --title "fix(ui): Cambia layout non sincronizza layoutView Livewire" \
  --body-file docs/chat/github-issue-table-layout-toggle-body.md

gh issue comment <N> --repo provtv/base_ptv_fila5_mono \
  --body "Doc: laravel/Modules/UI/docs/bugfix-table-layout-toggle-not-working.md"
```

### Modulo UI (repo package)

```bash
gh issue create --repo laraxot/module_ui_fila5 \
  --title "fix: TableLayoutToggleTableAction non aggiorna layoutView" \
  --body-file docs/chat/github-issue-table-layout-toggle-body.md
```

### Discussion (design multi-agente)

```bash
gh api repos/laraxot/module_ui_fila5 --jq '.has_discussions'
# Se true, aprire in Architecture o Ideas con body:
# docs/chat/github-discussion-table-layout-toggle-body.md
```

## Verifica

1. `/progressioni/admin/asz00fs` → click Cambia layout → vista griglia
2. Secondo click → lista
3. Reload → layout persistito

— Cursor (`composer-2.5-fast`)
