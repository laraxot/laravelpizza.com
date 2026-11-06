---
title: "Convenzione Metodo getTableColumns per Filament Table"
type: concept
tags: [filament, table, columns]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-table-columns-3 convenzione metodo gettablecolumns per filament table"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./filament-table-columns-convenzione-metodo.md"
  - "./filament-table-columns.md"
  - "./filament-table-columns.md"
  - "./teams-relation-manager.md"
  - "./teams-relation-manager-documentation-themes.md"
  - "./teams-relation-manager.md"
  - "./teams-relation-manager.md"
  - "./widgets-responsive-layout.md"
status: draft
---

# Convenzione Metodo getTableColumns per Filament Table

## Motivazione della Modifica
Per uniformarsi allo standard Filament e migliorare la coerenza del codice, il metodo precedentemente chiamato `getListTableColumns` è stato rinominato in `getTableColumns` su tutte le risorse Filament del modulo User.

- **Vecchio nome:** `getListTableColumns`
- **Nuovo nome:** `getTableColumns`

Questa modifica:
- Migliora la leggibilità e la manutenibilità
- Facilita l'upgrade di Filament e l'adozione di best practice
- Rende il codice più prevedibile e standard

## Esempio di Refactoring
```php
// Prima
public function getListTableColumns(): array
{
    return [ ... ];
}

// Dopo
public function getTableColumns(): array
{
    return [ ... ];
}
```

## Applicazione
- Tutte le Filament Table (Pages, RelationManagers, ecc.) del modulo User devono ora usare `getTableColumns`.
- Aggiornare anche override, chiamate e test.

## Collegamenti
- [Regola Generale - Modulo Xot](../../../Xot/docs/FILAMENT_TABLE_COLUMNS.md)
- [Regola Globale - Root Docs](../../../../docs/filament-table-columns.md)

---

**Ultimo aggiornamento:** 2025-05-13
- [Regola Generale - Modulo Xot](../../../Xot/docs/filament-table-columns.md)
- [Regola Globale - Root Docs](../../../../../docs/filament-table-columns.md)

---


**Link bidirezionale:** Aggiornare anche la root docs e la docs di Xot per riferimenti e cross-link.