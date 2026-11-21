---
title: "gettablecolumns deprecation note"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "gettablecolumns deprecation note"
issues: []
discussions: []
module: Xot
topic: method-deprecation-documentation
canonical: ../../docs/filament/xotbase-manage-related-records.md
---

# Documento BMAD: `getTableColumns()` — NON deprecato, documentazione sostituto

## Contesto (second brain)

- **Story**: PHPStan 260 — `method.deprecated` su `XotBaseManageRelatedRecords::getTableColumns()`
- **Regola**: `docs/wiki/rules/module-contracts-naming-placement.md` + `docs/wiki/rules/quality-gate-after-edit.md`
- **Verdetto utente**: NON è deprecata; la USO; documentare il consiglio sostituto.

## Verifica empirica nel codice

File: `laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php`

- `table()` è `final` (linea ~253) — NON può essere sovrascritto dalle sottoclassi.
- `getTableColumns()` è un **override point esplicito** (documentato nel docblock sopra linea 290):
  - `Default: quelle della Resource correlata`
  - Per estendere: `[...proprie, ...parent::getTableColumns()]`
- Il metodo viene chiamato internamente da `table()` per recuperare le colonne dalla `relatedResourceTable`.

## Perché PHPStan lo segnala

Il messaggio `Override the table() method to configure the table.` proviene dalla regola `method.deprecated` di Filament (o PHPStan plugin) che considera `getTableColumns()` deprecata nel framework Filament generico. In Xot però `getTableColumns()` è **architetturalmente necessario** perché la pagina è un proxy verso una `Resource` correlata (`ContactResource`, ecc.) e non verso la propria Resource; `table()` già costruisce tutto tramite `$resourceClass::table($table)`.

## Quale consiglio al posto (se si vuole cambiare)

| Obiettivo | Consiglio | Note |
|---|---|---|
| Modificare colonne della tabella correlata | **Sovrascrivi `getTableColumns()`** con `[...proprie, ...parent::getTableColumns()]` | L'unico modo supportato; `table()` è `final` |
| Configurare tabella globale (layout, sort, poll, striped) | **Non toccare** — già applicato da `$resourceClass::table()` | `table()` applica `HasXotTable::table()` sulla Resource correlata |
| Aggiungere colonne custom solo per questa pagina | Estendi `getTableColumns()`; se serve query scoping usa `modifyRelatedQuery()` (linea ~130) | Hook aggiunto 2026-09-11 |

## Raccomandazione

**Non rimuovere `getTableColumns()`**; è parte dell'architettura Xot (proxy a Resource correlata). Se PHPStan lo segnala come deprecato:

1. Verifica che sia `method.deprecated` dal framework Filament, non da Xot.
2. Aggiungi `phpstan-ignore` o `@phpstan-ignore` nel caso specifico se l'warning è falso positivo.
3. Non sostituire con override di `table()` — è `final`.

## Decisione loggata (on-demand)

> `docs/wiki/log.md` (aggiungere): `getTableColumns()` su `XotBaseManageRelatedRecords` NON deprecata — è override point per proxy alla Resource correlata; `table()` è `final`. Se PHPStan segnala deprecato, trattare come falso positivo del framework Filament.
