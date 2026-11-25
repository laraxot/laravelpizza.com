---
title: "Audit traduzioni .navigation: modulo Rating"
type: story
module: Rating
epic: quality
story_id: "navigation-translations-audit"
status: in-progress
track: quality/i18n
priority: P2
created: 2026-09-29
updated: 2026-09-29
related:
  - ../../../../../docs/wiki/i18n-navigation-translations.md
issues: []
discussions: []
tags: [docs, rating, bmad]
qmd: "audit traduzioni `.navigation`   modulo rating rating"
---
# Audit traduzioni `.navigation`: modulo Rating

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

Task utente 2026-09-29: trovare tutti i file di traduzione con la sottostringa
`.navigation` o una chiave `'navigation'`, completare/migliorare per ogni
lingua, senza mai togliere contenuto esistente. Dettaglio completo, metodo e
tabelle nel documento di sintesi cross-modulo:
`docs/wiki/i18n-navigation-translations.md`.

## Esito

1 correzione applicata su disco (`lang/it/rating.php`:
`navigation.name.label` da `Rating` non tradotto a `Valutazione`) ma
**non commitata da questo agente**: il file era già in scrittura concorrente
da un altro agente (verosimilmente sulla story Xot 5.251/5.253, "seconda
famiglia" di placeholder: `fields.rating.*` e `label` di primo livello
modificati da altri, non da questa sessione). La riga resta scritta e
disponibile per il commit di chi possiede quella story.

## Vincoli rispettati

- Nessuna chiave rimossa; solo sostituzioni di placeholder o aggiunte.
- Lock check eseguito a inizio sessione (`bashscripts/lock/status.sh`: nessun
  lock attivo di rilievo; `find laravel/Modules -name '*.php' -newermt "-5
  minutes"`: nessuna scrittura concorrente nella finestra immediata).
- `php -l` verde su ogni file toccato prima del commit.
- Commit solo sui file esattamente toccati (mai `git add -A`): il modulo ha
  working tree con modifiche concorrenti di altri agenti, verificate via
  `git diff -- <file>` prima di ogni `git add`.

## Second brain

Confermato: `qmd://concepts/translation-discipline-rule.md`. Pattern nuovo
scoperto (falso positivo euristica case-insensitive su valori Title Case) da
consolidare in una memoria Xot condivisa: vedi sintesi cross-modulo §6.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
