---
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
