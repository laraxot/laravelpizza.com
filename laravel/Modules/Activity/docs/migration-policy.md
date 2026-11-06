---
title: "Migration Policy"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "migration policy activity"
---
# Migration Policy

Regola canonica di progetto: [`docs/wiki/concepts/no-legacy-folders-code.md`](../../../../docs/wiki/concepts/no-legacy-folders-code.md)
- vietate cartelle `Legacy/`, `Old/`, `Deprecated/`, `Archive/`, e in generale
qualunque albero parallelo per "codice vecchio" (anche `_bak/`, anche se il
guard automatico controlla solo i nomi espliciti `legacy|deprecated|archive|old`).
La logica: un albero parallelo raddoppia la superficie da mantenere e rende
ambiguo cosa sia la SSoT. La cronologia vive in Git, non in cartelle.

## Principi

1. **Una sola migration owner per modello**: tutte le modifiche consolidate nel file `create_*` più recente
2. **Niente prefissi `add_*`, `fix_*`, `update_*`**: usare sempre il pattern `create_*` con `XotBaseMigration`
3. **Mai cancellare**: i file obsoleti si marcano `.php.old`, stesso path, nessuna sottocartella
4. **Nessuna cartella `_bak/` / `archive/`**: è stata rimossa il 2026-07-12: i 7 file al suo interno
   duplicavano 4 migration ancora attive alla radice (il consolidamento non era mai avvenuto realmente).
   Tutti i file dismessi ora vivono in `database/migrations/`, stesso path, suffisso `.php.old`.

## Convenzione `.old`

- Il suffisso `.php.old` impedisce a Laravel di caricare il file (lo scanner cerca `*.php`)
- Il suffisso `.old` è auto-esplicativo per chiunque legga la directory
- Nessuna cartella `archive/`: i file restano dov'erano, solo disabilitati
- Canon attivo: `2026_06_10_141000_create_activity_table.php` (`XotBaseMigration`, consolida
  `add_attribute_changes` + `fix_causer` + `update_schema`)
