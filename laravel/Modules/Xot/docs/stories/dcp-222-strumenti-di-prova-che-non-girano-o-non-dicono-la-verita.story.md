---
id: dcp-222
title: "DCP-222: strumenti di prova che non girano o non dicono la verita'"
type: story
epic: dc-parity-v2
status: ready-for-dev
priority: P1
owner: module:Xot
module: Xot
created: 2026-10-15
updated: 2026-10-15
qmd: "pest-scratch-db unbound variable StoryNumbersAreUniqueTest sqlite TestCase numerazione story collisioni FolioPageMountContractTest BladeTemplatesCompileTest go-live-gate json"
related: [dcp-154, dcp-184]
tags: [tooling, test, guardie, numerazione]
---

# DCP-222: strumenti di prova che non girano o non dicono la verita'

## Fase BMAD
Plan. Nasce da una giornata in cui piu' sessioni hanno lavorato insieme e la prova di cio' che e' vero e' stata, piu' volte, un test che non girava o uno strumento che mentiva. Una guardia che non gira non guarda.

## Fatti misurati (2026-10-15)
1. **La guardia dei numeri delle story non gira qui.** `Modules/Xot/tests/Unit/Docs/StoryNumbersAreUniqueTest.php` fa `uses(TestCase::class)` col `TestCase` di Xot, che vuole il database. Esito: con `pest` semplice `PDOException`; con `pest-scratch-db.sh` `SQLiteDatabaseDoesNotExistException`; 0 asserzioni in entrambi i casi. E' il test che dovrebbe impedire due story con lo stesso numero, e oggi i numeri si sono doppiati due volte in un'ora (187 poi 210, entrambi sistemati rinumerando la story piu' recente). Il test legge solo il filesystem.
2. **La riserva dei numeri non e' atomica.** Un controllo con `ls` e la creazione del file sono due passi: tre sessioni hanno preso la stessa serie in parallelo. `noclobber` protegge il nome del file, non il numero. Un controllo che blocca (nome e `id:`) ha evitato il terzo caso; non e' nel repository.
3. **`pest-scratch-db.sh` muore con `unbound variable`** se `DB_DATABASE_LIMESURVEY` non e' nel `.env`: `set -uo pipefail` (riga 15) e uso alla riga 38. Riprodotto con `env -u DB_DATABASE_LIMESURVEY`. Il giro di ripiego, usato da tutti, e' passare `DB_DATABASE_LIMESURVEY=`. Il file e' in modifica da un'altra sessione (cambio dell'ordine di clonazione): non l'ho toccato.
4. **L'exit code dello script e' corretto.** Con un test rosso (`FolioPageMountContractTest`) lo script esce 1. L'avvertenza «esce 0 anche con test rossi» scritta in una memoria precedente non e' piu' vera: da non ripetere.
5. **`FolioPageMountContractTest` e' rosso:** 1 test su 5, «container0 index usa mount lineare filament way senza logica domini…» (49 asserzioni totali). Segnalato dalla sessione che modifica `pages/[container0]/index.blade.php` (aggiunto `pageTitle`): contratto e file vanno riallineati da chi lo sta modificando.
6. **`BladeTemplatesCompileTest` non ha concluso in 150 s** nel mio run. Non e' una prova di successo ne' di fallimento: la compilazione dei Blade modificati oggi e' provata solo dal rendering reale delle pagine.
7. **Gate di messa in produzione.** `go-live-gate.py --json` stampava l'array JSON e, sempre, la riga «RISULTATO» sullo stesso stdout, quindi l'output non era JSON valido (`json.load` falliva con `Extra data`). **Corretto in questo giro:** in modalita' `--json` la riga va su stderr. Verifica: stdout parsato con `json.loads` stretto, 32 controlli; stderr contiene il RISULTATO. Resta da dire nella documentazione di DCP-154 che stdout e' JSON e stderr e' il riepilogo.

## Cose da fare
- [ ] **T1.** Togliere la dipendenza dal database da `StoryNumbersAreUniqueTest` (nessun `uses(TestCase::class)`; il test legge file). Prova richiesta: rosso se si crea una story con un numero gia' preso, verde dopo la rinumerazione.
- [ ] **T2.** Dopo T1, rimisurare il tetto storico di collisioni del test (il test dice che puo' solo scendere).
- [ ] **T3.** `pest-scratch-db.sh`: usare `${DB_DATABASE_LIMESURVEY:-}` (e le altre variabili lette dal `.env`) invece di fidarsi che esistano. Lo fa chi ha il file in mano; poi togliere il giro di ripiego dalle istruzioni.
- [ ] **T4.** `BladeTemplatesCompileTest`: capire perche' non conclude in 150 s (numero di viste? un file che si blocca?) e dargli un limite di tempo che fallisce con un messaggio, non in silenzio.
- [ ] **T5.** `FolioPageMountContractTest`: riallineare contratto e `pages/[container0]/index.blade.php` (proprietario: sessione del tema).
- [ ] **T6.** Documentare in DCP-154 che `go-live-gate.py --json` scrive JSON su stdout e il riepilogo su stderr.

## Decisioni da prendere
| ID | Chi decide | Domanda | Opzioni | Proposta |
|---|---|---|---|---|
| D222-1 | Titolare tecnico | Come si riservano i numeri delle story | A) uno script che blocca se il numero e' gia' in un nome o in un `id:`, da lanciare prima di creare il file, piu' T1 in modo che il test lo prenda; B) un prefisso per sessione; C) niente numero per le story non numerate (la regola dei nomi non lo richiede) | **A**: 5 righe, nessuna convenzione nuova, e T1 e' la rete di sicurezza |
| D222-2 | Titolare tecnico | Un tempo massimo per i test lanciati dagli agenti | nessuno; 120 s con messaggio | 120 s con messaggio chiaro: oggi un test lento sparisce in background e nessuno lo rilegge |

## Criteri di accettazione
1. `StoryNumbersAreUniqueTest` gira senza database e fallisce se due story hanno lo stesso `id:`.
2. `env -u DB_DATABASE_LIMESURVEY bash bashscripts/tools/pest-scratch-db.sh <test>` non esce con `unbound variable`.
3. `BladeTemplatesCompileTest` finisce, o dice perche' non ha finito.

## Non verificato
La causa della lentezza di `BladeTemplatesCompileTest`; se altri test del progetto dipendono dal database senza bisogno.
