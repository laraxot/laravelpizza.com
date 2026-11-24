---
<<<<<<< HEAD
status: accepted
date: 2026-11-19
decision-makers: utente (marco76tv), agente Claude
title: "ADR — Harness minimo per gli agenti: ambiente leggibile, memoria verificabile, guard sulle azioni vietate"
type: decision
module: Xot
tags: [adr, harness, agenti, guard, hook, memoria, bmad]
qmd: "harness agenti AGENTS.md mappa topology commands environment pitfalls conflicts facts lessons guard pretooluse task contract behavioral contract"
related:
  - ./pest-testcase-binding-per-file.md
  - ./architecture-tests-pest-arch.md
  - ../stories/sync-unrelated-histories-repair.story.md
  - ../../tests/Unit/Harness/GuardTest.php
---

# Harness minimo per gli agenti, sul modello del workshop laravelday

## Contesto

Su questo repo lavorano più agenti (Claude, Codex, Cursor) e una sync che committa ogni minuto. Le regole esistono
(CLAUDE.md, `docs/wiki/rules`, memorie) ma sono prosa: un agente le legge, o no, e niente impedisce di violarle.
Nello stesso giorno abbiamo visto un merge di sync committato con 2.424 file con marker, test che non partivano da
mesi con PHPStan verde, un test che cancellava `lang/en`. Il workshop laravelday-harness (`/var/www/laravelday-harness-workshop/.harness`)
propone un harness minimo: ambiente leggibile, fatti verificabili, contract, lezioni che diventano controlli.
Quanto di quell'harness adottiamo, e in che forma, senza duplicare BMAD, la wiki e il second brain che ci sono già?

## Driver della decisione

- Le regole devono essere **verificabili da una macchina**, non solo scritte.
- Un hook deve funzionare anche quando l'app è rotta (oggi PHPStan e Laravel non partivano): PHP puro, niente bootstrap.
- Niente doppioni: la story BMAD nel modulo owner resta il luogo del lavoro; `docs/contracts/` e `docs/adr/` esistono già in ogni modulo.
- `.claude` è un symlink a `bashscripts/ai/.agents`, condiviso da altri progetti: un hook lì non deve rompere un progetto senza `.harness/`.
- Le regole del progetto battono quelle del workshop dove divergono (migrazioni: qui si evolve lo schema con `tableUpdate()`).

## Alternative scartate

- **A — Adottare l'harness del workshop così com'è** (`.harness/` con tasks, rules, stop hook con receipt, trace).
  Scartata: il Task Contract con scope e stop hook bloccante su ogni "fatto" pesa su sessioni che spesso sono
  campagne su 19 pacchetti; lo stop che riesegue PHPStan e Pest costerebbe minuti a ogni chiusura.
- **B — Solo documentazione** (riscrivere CLAUDE.md come mappa). Scartata: è quello che c'era, e non ha impedito
  nessuno dei fallimenti di oggi.
- **C — Harness minimo adattato** (scelta): i pezzi che trasformano una regola in un controllo, mappati su quello che
  il progetto ha già.

## Decisione

Scelta: **C**, perché ogni pezzo risponde a un fallimento osservato (lezioni L-001…L-006) e riusa le strutture esistenti.

| Workshop | Qui |
|---|---|
| `AGENTS.md` come mappa (Topology, Commands, Environment, Pitfalls, Conflicts); `CLAUDE.md` = `@AGENTS.md` | Stesso: una fonte per Claude e Codex. Le regole lunghe restano nella wiki, linkate. |
| `.harness/memory/facts.md` + `verify E1` | `.harness/memory/facts.md`, comandi di sola lettura da `laravel/`; `php .harness/bin/verify-facts` li riesegue. |
| `lessons.md` (ogni lezione → un pezzo, con condizione di rimozione) | Stesso. |
| `decisions.md` → ADR se difficile da invertire, sorprendente, trade-off reale | Stesso; l'ADR va nel `docs/adr/` del modulo owner. |
| `progress.md` sovrascritto a fine sessione | Stesso; il dettaglio resta nella story BMAD. |
| Task Contract (`.harness/tasks/T-NNN.md`: scope, must_not_change, evidence, approval_required) | La **story BMAD** del modulo owner: per un task rischioso il suo frontmatter aggiunge `scope`, `must_not_change`, `evidence`, `approval_required`. Nessun file in più. |
| Behavioral Contract con invarianti = group Pest, `@contract` nel docblock | `docs/contracts/` del modulo; la classe lo cita con `@see` (regola dell'utente); un invariante con ID ha un test con `->group('<ID>')`. |
| Guard pre-tool (`.harness/rules/guard.php`) + trace | `.harness/bin/guard` (hook PreToolUse): `secrets.env`, `migration.destructive`, `db.fresh`, `git.rewind`; blocchi in `.harness/runs/trace.jsonl`. |
| `[ATTESA-UMANO]: <domanda>` per fermarsi su una decisione umana | Stesso, in `AGENTS.md` → Commands. |
| Stop hook con receipt | Non adottato (vedi A): il gate resta "PHPStan + Pest + verify-facts prima di dire fatto". |

## Conseguenze

- Buono, perché le regole più costose da violare (dati, segreti, storia git) ora sono bloccate prima che succeda, e il blocco lascia traccia.
- Buono, perché i fatti invecchiano in modo visibile: `verify-facts` esce con 1 quando uno non regge più.
- Buono, perché una sola mappa (`AGENTS.md`) serve tutti gli agenti invece di un diario di sessioni.
- Cattivo, perché il guard è euristico sui comandi shell: un comando composto in modi strani può passare. È una rete, non un muro.
- Cattivo, perché l'hook è registrato nel `settings.json` condiviso: un progetto che aggiunge un suo `.harness/bin/guard` lo attiva per sé.

## Conferma

- `vendor/bin/pest Modules/Xot/tests/Unit/Harness/GuardTest.php`: ogni regola ha un caso che scatta e uno vicino che passa.
- `php .harness/bin/verify-facts` esce con 0.
- `AGENTS.md` ha le 5 sezioni nell'ordine Topology, Commands, Environment, Pitfalls, Conflicts e `CLAUDE.md` lo importa.
- Ogni voce di `.harness/memory/lessons.md` nomina un pezzo di harness che esiste.
=======
title: "ADR — Harness per gli agenti: guide scritte (ADR, contratti) + sensori eseguibili (test, guard)"
type: decision
status: accepted
created: 2026-11-19
updated: 2026-11-24
module: Xot
decision-makers: [marco76tv, agente Claude]
tags: [adr, harness, agenti, guard, hook, contracts, bmad, second-brain]
qmd: "harness agenti laravelday workshop guard pretooluse lessons adr contracts invarianti group pest sensori guide feedforward feedback"
related:
  - ../rules/action-behavioral-contract.md
  - ../concepts/agent-harness-guide.md
  - ../../tests/Unit/Harness/GuardTest.php
  - ../../tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php
  - ../../tests/Unit/Docs/ActionContractsAreCompleteTest.php
---

# ADR: harness minimo, mappato su quello che il progetto ha già

## Contesto

Su questo repo lavorano più agenti (Claude, Codex, Cursor) e una sync automatica che committa ogni minuto. Le regole
esistono (AGENTS.md, wiki `docs/wiki/rules`, memorie, story BMAD, CLAUDE.md) ma erano quasi tutte prosa: un agente le
legge, o no, e niente impedisce di violarle. Fallimenti osservati: merge di sync committato con 2.424 file con marker
(2026-11-19); test che non partivano da mesi con PHPStan verde; un test che cancellava `lang/en`; 12 moduli con un
`docs/adr/README.md` identico e nessun ADR; un ADR copiato dal workshop con classi inesistenti qui; un test di
documentazione rosso che nessuno vedeva (2026-11-24). Il workshop laravelday-harness (R. Gallea, Laravel Day 2026,
https://github.com/robertogallea/laravelday-harness-workshop) propone un harness in sei livelli (task delimitato,
ambiente leggibile, azioni controllate, esecuzione durevole, evidenza, apprendimento), la cui versione minima sono
ambiente leggibile, fatti verificabili, contract e lezioni che diventano controlli. Quanto ne adottiamo, e in che forma,
senza duplicare BMAD, la wiki e il second brain che ci sono già?

## Driver della decisione

- Le regole devono essere **verificabili da una macchina**, non solo scritte.
- Un hook deve funzionare anche quando l'app è rotta (PHPStan e Laravel non partivano): PHP puro, niente bootstrap.
- Niente doppioni: la story BMAD nel modulo owner resta il luogo del lavoro; `docs/contracts/` e `docs/adr/` esistono
  già in ogni modulo e tema.
- `.claude` è un symlink a `bashscripts/ai/.agents`, condiviso da altri progetti: un hook lì non deve rompere un
  progetto senza `.harness/`.
- Le regole del progetto battono quelle del workshop dove divergono (migrazioni: qui si evolve lo schema con
  `tableUpdate()`).

## Alternative scartate

- **Adottare il kit del workshop così com'è** (`.harness/tasks`, stop hook con receipt che rilancia PHPStan e Pest a
  ogni "fatto"): su sessioni che toccano 26 pacchetti, spesso campagne su molti pacchetti insieme, lo stop costerebbe
  minuti a ogni chiusura, e il Task Contract con scope e stop hook bloccante duplica la story BMAD.
- **Solo documentazione** (riscrivere CLAUDE.md come manuale o come mappa): è quello che c'era, e non ha impedito
  nessuno dei fallimenti.
- **ADR e contratti centrali in `docs/` di root**: rompono l'ownership dei moduli, che sono repo git propri condivisi
  tra progetti; il canon vive nel pacchetto che possiede il codice.
- **Numerazione `NNNN-` degli ADR come nel workshop**: vietata dalla regola dei nomi file del progetto (nessun numero né
  data nel nome); due progetti che condividono Xot hanno già prodotto numeri doppi (`0006` due volte, `0010`/`00010`).

## Decisione

Scelta: l'**harness minimo adattato** (nello studio iniziale, opzione C), perché ogni pezzo risponde a un fallimento
osservato e riusa strutture esistenti. Adottiamo i pezzi che trasformano una regola in un **controllo eseguibile**,
ciascuno mappato su una struttura esistente e ciascuno nato da una lezione (`.harness/memory/lessons.md`, con
condizione di rimozione):

| Workshop | Qui |
|---|---|
| `AGENTS.md` mappa, `CLAUDE.md` stub | Stessi file, una sola mappa per Claude e Codex; CLAUDE.md è uno stub ≤50 righe e rimanda al canon ADR/contratti del pacchetto owner; le regole lunghe restano nella wiki, linkate. |
| `docs/adr/NNNN-*.md` (MADR breve) | `docs/adr/<argomento>.md` **in ogni modulo e tema**, senza numeri né date; sezioni Contesto, Decisione, Alternative scartate, Conseguenze, **Verifica** (= *Confirmation*). |
| `docs/contracts/<op>.md` + `INDEX.md` | `docs/contracts/<action-kebab>.md` in ogni pacchetto; `README.md` è l'indice (uno solo). Invarianti in tabella con ID `<PREFISSO>-INV-<N>` e group Pest omonimo; docblock `@contract`. |
| `verify-port` (linter di struttura) | `PackagesHaveContractsAndAdrTest` + `ActionContractsAreCompleteTest`, source-level, nella suite Pest. |
| Guard PreToolUse + trace | `.harness/bin/guard` (PHP puro), regole `secrets.env`, `migration.destructive`, `db.fresh`, `git.rewind`; blocchi in `.harness/runs/trace.jsonl` (gitignored). Registrato come hook PreToolUse in `.claude/settings.json` (cartella ignorata da git: si registra per checkout; la stessa voce è in `bashscripts/ai/.agents/settings.json` per i progetti che usano il symlink). Il comando non fa nulla dove il guard manca. |
| `lessons.md` (ogni lezione → un pezzo, con condizione di rimozione) | `.harness/memory/lessons.md`. |
| Task Contract `T-NNN` (scope, `must_not_change`, evidence, `approval_required`) | La **story BMAD** del modulo owner (scope, criteri, evidenza, write-back); per un task rischioso il frontmatter della story aggiunge quei campi. Nessun file in più. |
| `progress.md`, `decisions.md` | La story BMAD e, per le decisioni difficili da invertire, sorprendenti o con un trade-off reale, un ADR del pacchetto owner. |
| `[ATTESA-UMANO]: <domanda>` | Stesso marcatore, usato dai messaggi del guard e da AGENTS.md. |
| Stop hook con receipt | Non adottato (vedi prima alternativa): il gate resta "PHPStan + Pest prima di dire fatto". |
| `.harness/memory/facts.md` + `verify E1` | Proposto nella prima stesura (`facts.md` con comandi di sola lettura da `laravel/`, riesecuzione con `php .harness/bin/verify-facts`) e **non adottato**: né `facts.md` né `verify-facts` esistono nel repo. Si riapre con un nuovo ADR se serve. |

## Conseguenze

- Buono: le regole più costose da violare (dati, segreti, storia git) sono bloccate prima che succeda, con traccia.
- Buono: un ADR o un contratto vuoto, copiato o scollegato dal codice fa fallire un test; un'invariante dichiarata
  coperta da un group che non esiste pure.
- Buono: chi apre un pacchetto trova nel README di `docs/adr` e `docs/contracts` l'indice di tutto, senza cercare nella
  wiki; una sola mappa (`AGENTS.md`) serve tutti gli agenti invece di un diario di sessioni.
- Cattivo: il guard è euristico sui comandi shell (una rete, non un muro), e può dare falsi positivi (per esempio un
  messaggio di commit che contiene «reset --hard», o una scrittura di documentazione che nomina il trait di reset del
  database): si riformula il comando o il testo.
- Cattivo: l'hook è registrato nel `settings.json` condiviso: un progetto che aggiunge un suo `.harness/bin/guard` lo
  attiva per sé.
- Cattivo: molte invarianti nascono con group `—` (debito dichiarato); il valore cresce solo se chi tocca un'Action
  aggiunge il test del suo group.

## Conferma

- Ogni regola del guard ha un caso che scatta e uno vicino che passa, e il test gira senza bootstrap Laravel.
- Ogni voce di `.harness/memory/lessons.md` nomina un pezzo di harness che esiste (revisione).
- Criterio della prima stesura: `AGENTS.md` con le sezioni Topology, Commands, Environment, Pitfalls, Conflicts e
  `CLAUDE.md` che lo importa. Stato al 2026-11-24: non vero (le sezioni di `AGENTS.md` di root sono Navigazione
  Rapida, Stack Tecnologico, Quick Start, Documentazione Esistente, Riferimenti Bidirezionali, Protocollo persistente di
  lavoro AI; `CLAUDE.md` è uno stub di 50 righe): da riallineare o togliere con un ADR successivo.

## Verifica

```bash
cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Harness \
  Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php \
  Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php
```

- `Modules/Xot/tests/Unit/Harness/GuardTest.php`: ogni regola del guard ha un caso che scatta e uno vicino che passa;
  gira senza bootstrap Laravel. `Modules/Xot/tests/Unit/Harness/NoConflictMarkersInCodeTest.php` sta nella stessa
  cartella.
- Gli altri documenti citano uno script `composer harness:check` come scorciatoia di questo comando; al 2026-11-24 non
  risulta definito in `laravel/composer.json`, quindi qui si usa il comando esplicito.
- Stato di `.harness/memory/lessons.md`: assente in questo checkout (`.harness/` contiene solo `bin/guard` e `runs/`),
  quindi la revisione sulle lezioni non è eseguibile finché il file non viene creato o ripristinato.
>>>>>>> laraxot/dev
