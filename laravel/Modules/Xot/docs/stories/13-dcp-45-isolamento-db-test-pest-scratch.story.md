---
id: dcp-45
title: "I test lanciati con pest-scratch-db.sh possono finire sul DB di sviluppo"
type: story
epic: dc-parity-v2
status: open
priority: P1
owner: module:Xot
module: Xot
created: 2026-10-13
updated: 2026-10-13
tags: [test, database, isolamento, tooling]
qmd: "dcp-45 I test lanciati con pest-scratch-db.sh possono finire sul DB di sviluppo"
related: [dcp-35, dcp-40]
---

# DCP-45: isolamento del database nei test

## Evidenza (subagent S3 e S1 di DCP-35, 2026-10-13)
- Con `laravel/bootstrap/cache/config.php` presente le variabili d'ambiente non hanno effetto: tutte le connessioni restano su `fixcity_data` e `fixcity_user` (DB di sviluppo). Un run esplorativo con `GET` e riga creata dalla factory e' finito su `fixcity_data`, annullato dalla transazione di `DatabaseTransactions`; conteggi prima/dopo identici (utenti 7, ticket 2).
- Due variabili con due scopi diversi: `DB_DATABASE_LIMESURVEY=` serve a FAR PARTIRE lo script (ha `set -u`; `.env*` non la definisce, senza si ferma prima di pest); `APP_CONFIG_CACHE=/nonexistent/config.php` serve a ISOLARE (senza, la config in cache vince sulle variabili). Con entrambe, un probe di S3 ha confermato che ogni connessione non sqlite punta al DB scratch; il lead le ha usate il 2026-10-13 ~14:00 UTC (6 test, conteggi DB di sviluppo invariati: 7 utenti, 2 ticket).
- Esiste una ricetta diversa in `Themes/Sixteen/docs/bmad/stories/2026-10-13-dcp-97-registro-flusso-tickets-numerazione-e-coordinamento.story.md` (riga 34): `APP_ENV=testing DB_CONNECTION=sqlite APP_CONFIG_CACHE=/tmp/<file inesistente> ./vendor/bin/pest <file>`. Contraddice il commento dello script (`pest-scratch-db.sh` riga 4: mai SQLite) e non e' stata provata dal lead: da riconciliare.
- S1: una sonda con `phpunit.xml` dava `env=local` e `fixcity_data`, non `.env.testing`.
- Nel DB di sviluppo restano due ticket Faker (`TCK-CLIQUERY`, `TCK-CLIQUERY2`, creati 2026-10-13 14:54 ora locale, owner casuali) la cui origine non e' tracciata (nomi `TCK-CLIQUERY*` suggeriscono un test CLI, ipotesi non provata; creati alle 12:54 UTC se il fuso e' UTC+2, cioe' prima dei subagent di DCP-35 delle 12:57).

## Rischio
Un test con `RefreshDatabase` lanciato con il solo `pest-scratch-db.sh` puo' azzerare o sporcare i dati dell'app che l'utente sta usando.

## Proposta (non applicata, `bashscripts/tools/pest-scratch-db.sh` non e' stato toccato)
1. Lo script deve imporre da solo `APP_CONFIG_CACHE` verso un percorso inesistente e dare un default a `DB_DATABASE_LIMESURVEY`.
2. Controllo di sicurezza prima di eseguire: se `DB_DATABASE` risolto non e' scratch/sqlite, rifiutare.
3. Test Xot che fallisce se una connessione di test punta a `fixcity_data`.
4. Capire chi ha creato i due ticket `TCK-CLIQUERY*` e ripulirli solo con conferma dell'utente.

## Verifica richiesta alla chiusura
Output di un run con config in cache che mostra le connessioni su DB scratch; conteggi del DB di sviluppo invariati.

## Aggiornamento 14:28 UTC (lead DCP-35): i conteggi del DB di sviluppo sono cambiati, non per i test
Alle 14:26 UTC il DB di sviluppo ha 9 utenti e 3 ticket (prima 7 e 2). I nuovi record non vengono da `pest-scratch-db.sh`: l'utente "Giulia Bianchi" `dcp-parity-test@example.test` (14:09 UTC), l'utente "David Heaney IV" e il ticket `AN4059281` (14:19 UTC) sono la fixture creata dalla sessione tema per le misure autenticate, dopo il "procedi" dell'utente (DCP-98). I conteggi prima/dopo di ogni run dei test (7/2, poi 9/3) sono comunque uguali: i test restano isolati. Origine dei 2 ticket Faker `TCK-CLIQUERY*` (12:54 UTC): ancora non tracciata.
