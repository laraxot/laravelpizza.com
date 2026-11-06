---
title: "Xot: created_by e deleted_by scritti davvero dal trait Updater"
type: story
status: review
priority: P1
created: 2026-11-05
updated: 2026-11-05
module: Xot
depends_on: []
related: [roosko-audit]
owned_scope: [app/Traits/Updater.php]
tags: [audit-trail, updater, created_by, soft-delete]
qmd: "xot updater created_by updated_by deleted_by audit trail soft delete"
---

# Xot: created_by e deleted_by scritti davvero dal trait Updater

## Story

Come **responsabile di un dato con valore legale** (registro rifiuti, movimenti, pesate)
voglio **sapere chi ha creato ed eliminato ogni record**
così da **avere un audit trail affidabile**.

## Perché (evidenza)

- `creating` controllava `array_key_exists('created_by', $model->getAttributes())`: su un modello nuovo gli attributi contengono solo i campi valorizzati, quindi `created_by` e `updated_by` non venivano mai scritti in creazione.
- `deleting` impostava `deleted_by` senza salvarlo: il soft delete aggiorna solo `deleted_at`/`updated_at`.
- Emerso dall'audit Roosko (rilievo database R8); riguarda tutti i progetti Laraxot.

## Acceptance criteria

1. Un record creato da un utente autenticato ha `created_by` e `updated_by` valorizzati se le colonne esistono.
2. Un valore esplicito di `created_by` non viene sovrascritto.
3. Il soft delete salva `deleted_by`; il force delete non fa salvataggi inutili.
4. Tabelle senza quelle colonne: nessun errore, nessuna query di scrittura in più (verifica dello schema memorizzata per tabella).

## Dev agent record

- 2026-11-05 — Claude: verifica colonne tramite schema con cache per connessione/tabella; `saveQuietly()` prima del soft delete. `php -l` ok; test Pest da aggiungere quando l'ambiente con vendor è disponibile.
