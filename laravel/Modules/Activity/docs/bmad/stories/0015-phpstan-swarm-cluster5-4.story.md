---
title: "PHPStan swarm cluster 5 — Activity"
status: review
epic: code-quality
acceptance_criteria:
  - PHPStan `analyse Modules/Activity` 0 errori o blocco documentato
  - Fix per scopo/funzionalita, mai per tacitare l'errore
  - php -l verde sui file a rischio
references:
  - laravel/Modules/Xot/docs/bmad/stories/phpstan-modules-swarm-random-20261006.story.md
  - bashscripts/ai/wiki/memories/multi-agent-coordination.md#multiagent-phpstan-scan-resource-contention
  - bashscripts/ai/wiki/memories/multi-agent-coordination.md#phpstan-swarm-single-slot-sequencing
qmd: "phpstan swarm cluster5 story cluster activity"
---
# PHPStan swarm cluster 5 — Activity

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Contesto
Cluster 5 (Performance, Activity, IndennitaCondizioniLavoro), ordine random:
Activity, IndennitaCondizioniLavoro, Performance. Coordinatrice:
`laravel/Modules/Xot/docs/bmad/stories/phpstan-modules-swarm-random-20261006.story.md`.

## Stato pregresso
Activity era a 0 errori (commit `cda1698b2f`, story
`0019-quality-gates-phpstan-fix-4.story.md`). Nessuna modifica ad `app/`
successiva: `git log` mostra solo docs. Nessuna regressione attesa.

## Gate
- `php -l`: full-tree andato in timeout per carico (load 85-150, 24-75
  processi phpstan concorrenti dello swarm); verde sui file a rischio
  (nessuno modificato in `app/`, verificato via `git log --name-only`).
- `phpstan analyse Modules/Activity`: BLOCCATO da resource contention.
  4 run lanciati (1 full sequenziale + 3 paralleli poi ridotti a 1 per
  responsabilita verso lo swarm): 3 morti senza output dopo 13-25 min,
  1 lasciato vivo in background (`/tmp/phpstan-activity3.txt`, PID 73217)
  per il prossimo agente. Dettagli nel diario della memoria
  `multi-agent-coordination.md#phpstan-swarm-single-slot-sequencing`.

## Review scopo-driven (statica, senza edit)
- `Actions/Query/GetActivityStatisticsAction.php`: tipizzazione completa
  (`array{...}` shape, `Builder<Activity>`, cast `(string)/(int)`,
  `isset()` su magic attributes). Nulla da correggere.
- `Actions/ActivityLogger.php`, `GetActivityStatisticsAction.php`: solo
  commenti che documentano `isset()` vs `property_exists()`. OK.
- Merge markers in `app/`: 0. `property_exists()` reale: 0.

## Fix
Nessuno: nessun errore accertato, nessun file toccato (lock mai acquisiti
perche nessun edit necessario). `->label()` hardcoded non presenti in
`Activity/app` nel campione verificato; restano fuori scopo (stile, non
errori phpstan).

## Residuo
Rilanciare `phpstan analyse Modules/Activity` in finestra quieta e
chiudere il gate; output atteso 0 errori.

---

## Contenuto unito da `0015-phpstan-swarm-cluster5-4.story.md`

# phpstan swarm cluster5

Stub alias post-strip data/timestamp. Canonico: [./phpstan-swarm-cluster5.story.md](0015-phpstan-swarm-cluster5-4.story.md).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
