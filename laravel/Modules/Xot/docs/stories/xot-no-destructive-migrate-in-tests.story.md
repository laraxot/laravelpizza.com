---
id: xot-no-destructive-migrate-in-tests
title: "Vietare migrate --force nei test di Xot con un test di architettura"
type: story
status: in-progress
priority: P0
owner: module:Xot
module: Xot
tags: [sicurezza, database, test, architettura, dati-sacri]
related: [test-database-guard]
---

# Vietare migrate --force nei test di Xot

Fase BMAD: Dev (guardia permanente).

## Scopo originale
Il test `can run migrations` in `Modules/Xot/tests/Unit/SimpleModelsTest.php` lanciava `migrate --env=testing --force` sul database di test condiviso (`ptv_lara_test` su 10.100.200.53). La regola del progetto vieta `--force` e le operazioni distruttive sul DB ("dati sacri").

## Stato
- Il test è stato rimosso dal working tree, non ancora committato. Nessuna guardia impedisce di reintrodurlo.
- Un test di guardia nel bootstrap (`test-database-guard`) copre le connessioni, non le chiamate `migrate`.

## Azioni
1. Aggiungere un test di architettura che fallisce se un file in `Modules/*/tests` contiene `'--force'` in una chiamata Artisan o `migrate:fresh`.
2. Documentare la regola in `laravel/Modules/Xot/docs` con il riferimento alla regola del progetto.

## Verifica
- Il test di architettura passa sul codice attuale.
- Un file di prova con `migrate --force` lo fa fallire (poi rimosso).
