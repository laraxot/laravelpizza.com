---
title: Profilo di test per le connessioni tenant
status: todo
module: Tenant
created: 2026-10-21
---

# Profilo di test per le connessioni tenant

## Problema
Pest non parte: `Modules/Xot/tests/Support/TestDatabaseGuard.php` rifiuta ogni run se una connessione non finisce
per `_test`. Le connessioni arrivano dal profilo tenant scelto dal dominio (es. `config/localhost/database.php`),
non da `.env.testing`. In CLI il profilo ricade su `localhost`, che punta a database di produzione (`ptv_lara`, `badge`, ...).

## Obiettivo
Un profilo di test dove ogni connessione e' SQLite (in memoria o file) oppure un database `*_test`, selezionato
solo in ambiente testing. Il guard resta invariato.

## Vincoli
- Non abbassare o aggirare il guard.
- Non toccare i database di produzione. Creare solo `*_test` locali, additivi.
- Nessun `migrate:fresh` o `RefreshDatabase` su database non `_test`.

## Passi
1. Mappare la selezione del profilo in `GetTenantNameAction` e `GetTenantConfigNamesAction` (Tenant).
2. Definire il profilo di test (es. `config/testing/`) con tutte le connessioni su SQLite in memoria.
3. Verificare che le migrazioni dei moduli girino su SQLite per i test che le richiedono; documentare le eccezioni.
4. Eseguire la suite di un modulo pilota (User o Sigma) e riportare l'output.

## Verifica
- `./vendor/bin/pest Modules/Xot/tests/...` parte senza il messaggio del guard.
- Il guard continua a rifiutare una connessione non `_test` (test di regressione del guard).
