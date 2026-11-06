---
id: xot-test-env-pending-migrations
title: "Applicare a mano le migrazioni pendenti del DB di test per ModelsTest"
type: story
status: blocked
priority: P1
owner: module:Xot
module: Xot
tags: [ambiente, database, test, migrazioni]
related: [xot-no-destructive-migrate-in-tests, test-database-guard]
---

# Applicare a mano le migrazioni pendenti del DB di test

Fase BMAD: Dev (azione ambiente, serve conferma).

## Stato
- `ModelsTest` ("can create a test tenant") fallisce: la tabella `tenants` non esiste nel DB di test `ptv_lara_test`, con 99 migrazioni pendenti.
- Il codice è corretto. Il problema è l'ambiente.
- `tests/TestCase.php` prevede una migrazione manuale una tantum con `php artisan migrate --env=testing`, che non è stata eseguita.

## Blocco
Eseguire migrazioni sul database condiviso è una scelta di ambiente da confermare. Non è un'operazione automatica.

## Azioni
1. Confermare il target del DB di test e che sia usa e getta (`_test` nel nome, non produzione).
2. Dopo conferma: `php artisan migrate --env=testing` una volta, come da `tests/TestCase.php`.
3. Rilanciare `ModelsTest`.

## Verifica
- `ModelsTest` verde dopo la migrazione manuale.
