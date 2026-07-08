# Filament Resource: Schemas e Tables (tema Three)

## Scopo

Risorse Filament nel tema Three seguono la convenzione Laraxot: schema form/infolist in `Schemas/`, colonne in `Tables/`.

## Struttura

```
Themes/Three/app/Filament/Resources/{ResourceName}/
├── Schemas/
│   ├── {Entity}Form.php
│   └── {Entity}Infolist.php
├── Tables/
│   └── {Entities}Table.php
└── {ResourceName}.php
```

## Regole

- Classi base Xot (`XotBaseResourceForm`, `XotBaseResourceInfolist`, `XotBaseResourceTable`).
- Array con chiavi stringa; niente label hardcoded sui componenti.
- **`getPages()`:** omettere se solo CRUD standard e naming Page allineato — [regola Xot](../../Modules/Xot/docs/filament/getpages-redundancy-rule.md).
- **Copia Page → `*Table`:** `getHeaderActions()` → `getTableHeaderActions()`, `$this->getModel()` → FQCN, `$this->tableFilters ?? []`, niente `#[Override]`. **NON** creare override `return parent::getTableXxx();` o `return [];` (= default, viola DRY+KISS). Dettaglio: [Progressioni](../../Modules/Progressioni/docs/filament-resource-schemas-tables.md#copia-metodi-tabella-page--classe-table-override-utili-vs-inutili).

## Riferimenti

- [Xot – Filament v5 hybrid pattern](../../Modules/Xot/docs/wiki/concepts/filament-v5-hybrid-pattern.md)
- [Progressioni – migrazione](../../Modules/Progressioni/docs/filament-resource-schemas-tables.md)
- [Progressioni – wire pilota Assenze](../../Modules/Progressioni/docs/filament-resource-wire-assenze.md)
- [One](../One/docs/filament-resource-schemas-tables.md) · [Zero](../Zero/docs/filament-resource-schemas-tables.md)
- [Cursor rule](../../../.cursor/rules/filament-resource-schemas-tables.mdc)

*Ultimo aggiornamento: giugno 2025*
