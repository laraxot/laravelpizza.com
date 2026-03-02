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
- [Regola Generale - Modulo Xot](../../../xot/docs/filament_table_columns.md)
- [Regola Globale - Root Docs](../../../../../../../docs/filament-table-columns.md)

---


**Link bidirezionale:** Aggiornare anche la root docs e la docs di Xot per riferimenti e cross-link.
