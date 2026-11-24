---
title: "Harness per agenti AI — perché, come si usa, come si mantiene"
type: concept
module: Xot
tags: [harness, agenti, adr, contracts, guard, bmad, second-brain, ecc]
created: 2026-11-24
updated: 2026-11-24
qmd: "harness engineering agenti perche come usare adr contracts invarianti guard lessons bmad second brain ecc laravelday gallea openai fowler anthropic"
related:
  - ../adr/agent-harness.md
  - ../rules/action-behavioral-contract.md
  - ../../../../../.harness/memory/lessons.md
---

# Harness per agenti AI

**Agente = modello + harness.** Il modello è lo stesso per tutti; l'harness è tutto quello che gli sta intorno e decide se
il risultato è *plausibile* (compila, i test che si è scritto da solo passano, il riassunto convince) o *corretto*
(rispetta invarianti scritte, con evidenza prodotta dal sistema). Se un'invariante non è scritta, la domanda «è corretto?»
non ha risposta: quel buco è il pezzo di harness che manca.

Fonti: workshop [laravelday-harness-workshop](https://github.com/robertogallea/laravelday-harness-workshop) (R. Gallea);
[OpenAI — Harness engineering](https://openai.com/index/harness-engineering/);
[B. Böckeler — Harness engineering](https://martinfowler.com/articles/harness-engineering.html);
[Anthropic — Effective harnesses for long-running agents](https://www.anthropic.com/engineering/effective-harnesses-for-long-running-agents).

## Perché

1. **Un agente copia il codice più vicino, difetti compresi.** Nel workshop l'agente deve aggiungere i rimborsi parziali e
   copia `RefundService`: autorizzazione nel posto sbagliato, niente transazione, migrazione distruttiva, «fatto» senza test.
   Qui i vicini pericolosi sono i Services legacy di AI/Geo/Job, i pattern Filament non XotBase, le migrazioni vecchie.
2. **Quello che l'agente non vede nel contesto non esiste** (OpenAI). Una regola in una chat, in una memoria privata o in
   una wiki di 4.000 file non letta, per lui non c'è.
3. **Le guide da sole non verificano, i sensori da soli ripetono gli errori** (Böckeler): servono *guide* (ADR, contratti,
   AGENTS.md: prima di agire) e *sensori* (test, arch, PHPStan, guard: dopo o durante), e i sensori computazionali battono
   quelli inferenziali (un LLM che giudica).
4. **Ogni pezzo deve rispondere a «quale fallimento impedisce?»** e avere una condizione di rimozione, altrimenti
   l'harness diventa burocrazia ([lessons](../../../../../.harness/memory/lessons.md)).
5. **Il lavoro dell'umano è governare l'harness**, non correggere a mano l'output: quando un errore si ripete, la
   correzione giusta è una regola eseguibile, non un altro prompt.

## I pezzi, nella nostra struttura

| Livello | Domanda | Pezzo qui |
|---|---|---|
| L1 Task delimitato | cosa devo fare, cosa non devo toccare, come provo che è fatto? | story BMAD nel `docs/stories/` del modulo/tema owner (criteri, file, comandi di verifica) |
| L2 Ambiente leggibile | dove sta cosa, perché ha questa forma, cosa promette? | `AGENTS.md` (mappa) → `docs/adr/` + `docs/contracts/` del pacchetto → wiki via QMD |
| L3 Azioni controllate | cosa non devo poter fare mai? | `.harness/bin/guard` (segreti, migrazioni distruttive, DB azzerato, git all'indietro) |
| L4 Esecuzione durevole | dove riprendo dopo un riavvio? | story BMAD (stato, claim, write-back), lock `bashscripts/lock`, second brain |
| L5 Evidenza | come provo che è corretto? | Pest per group di invariante, `arch()`, PHPStan max, test-sensore dei docs |
| L6 Apprendimento | come non ripeto l'errore? | `.harness/memory/lessons.md` → regola del guard / test / ADR; `trace.jsonl` |

## Come si usa (ogni task)

1. **Prima di toccare un pacchetto**: leggi `docs/adr/README.md` e `docs/contracts/README.md` del modulo o tema owner.
   Sono corti per costruzione e indicizzano tutto.
2. **Prima di chiamare, modificare o imitare un'Action con effetti collaterali**: leggi il suo contratto (`@contract` nel
   docblock). «Non fa» ti dice cosa non aggiungere; le invarianti ti dicono cosa non rompere.
3. **Se devi scegliere tra due forme di codice**: cerca l'ADR. Se non c'è e la scelta è difficile da invertire,
   sorprendente o un vero trade-off, scrivilo (stesso commit del codice).
4. **Se cambi un comportamento**: aggiorna il contratto nello stesso commit; se l'invariante ha un group, lancia
   `vendor/bin/pest Modules/<M>/tests --group=<ID>`; se è `—`, valuta di scrivere il test e dichiarare il group.
5. **Prima di dire «fatto»**: `cd laravel && composer harness:check` (sensori ADR/contratti/guard), i test del pacchetto, PHPStan sul pacchetto; scrivi esito ed exit code
   nella story BMAD (evidenza [D], non affermazione [A]).
6. **Se il guard ti blocca**: leggi il messaggio, fa' quello che dice invece; se pensi che serva davvero, fermati con
   `[ATTESA-UMANO]: <domanda>`. Non aggirarlo con un comando composto.
7. **Se scopri un fallimento nuovo e ricorrente**: aggiungi una lezione e il pezzo che la impedisce (regola del guard con
   `// lesson: L-NNN` e un caso in `GuardTest`, oppure un test, oppure un ADR).

## Conflitti: dove il codice esistente non è il modello

Regola generale (dal workshop): **il codice nuovo segue la convenzione dichiarata anche se il legacy è in produzione.**
Divergenze misurate il 2026-11-24:

| ID | Dove | Divergenza | Per il codice nuovo |
|---|---|---|---|
| C1 | `Modules/AI/app/Services`, `Modules/Geo/app/Services`, `Modules/Job/app/Services` | logica in Services | Action QueueableAction ([ADR](../adr/actions-over-services.md)); debito in `tests/Arch/debt.php` |
| C2 | 113 file di codice in 14 moduli, soprattutto User (28), Notify (21), Xot (17) (`ModuleCodeIsProjectAgnosticTest`) | il codice di un modulo condiviso nomina il progetto ospite | niente nomi di progetto: config, tenant, `XotData` |
| C3 | docs dei moduli (4.094 occorrenze contro un tetto di 1.261, `ModuleDocsAreProjectAgnosticTest`) | i docs nominano il progetto ospite | descrivi il ruolo, non l'installazione |
| C4 | contratti con invarianti a group `—` | promessa scritta ma non provata | chi tocca l'Action scrive il test del group |

## BMAD, ECC, second brain: chi fa cosa

- **BMAD** è il ciclo del lavoro: scopo → criteri verificabili → implementazione → verifica → write-back nella story.
  Le decisioni nate in una story che sono difficili da invertire diventano ADR del pacchetto; le promesse di un'Action
  diventano contratto. La story *rimanda* ad ADR e contratti, non li ricopia.
- **ECC** (Everything Claude Code) fornisce skill e hook generici: se ne usa una sola pertinente (es. `verification-loop`),
  mai quelle in conflitto con le regole del progetto (`laravel-patterns` prescrive Services: vietato qui).
- **Second brain** (wiki + QMD): la conoscenza trasversale e riusabile; ADR e contratti hanno `qmd:` nella frontmatter
  così una ricerca li trova. La wiki *rimanda* al canon nel pacchetto owner, non lo duplica.

## Come si mantiene (anti-decadimento)

- Un contratto che non corrisponde più al codice è peggio di nessun contratto: si aggiorna nello stesso commit.
- Un ADR superato non si cancella: `status: superseded` + `superseded_by:` e un ADR nuovo.
- Ogni lezione ha una condizione di rimozione; ogni tanto si rilegge `trace.jsonl`: una regola che non scatta mai da mesi
  si discute.
- Gli indici README li controlla il test: un file non elencato fa fallire la suite.
