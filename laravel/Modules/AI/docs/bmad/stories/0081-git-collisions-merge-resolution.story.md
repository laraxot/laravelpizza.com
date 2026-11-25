---
title: "Collisioni git 2026-11-25: merge aperti risolti e mappa dei marker committati"
type: story
epic: tooling-quality
module: Xot
status: review
created: 2026-11-25
qmd: "collisioni git merge aperti marker committati laraxot dev first orfano progressioni tenant zero notify"
related:
  - ./0091-merge-conflict-markers-committed-bonifica.story.md
  - ../../../../../../bashscripts/docs/stories/0031-0031-history-rewrite-real-guard.story.md
---
# Collisioni git 2026-11-25

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

Sessione Claude Opus 5.5 `48744b40`. Lock: `bashscripts/lock/git-collisions-20261125-{Progressioni,Tenant,Themes-Zero}`.

## Fatto: tre merge `laraxot/dev → dev` aperti stamattina, chiusi

| Repo | File in conflitto | Criterio | Commit |
|---|---:|---|---|
| Modules/Progressioni | 12 + 1 auto-merge con marker | theirs pulito; ours conteneva marker `.merge_file_*` che alternavano solo `qmd:` (verificato: ours lato 2 == theirs). `continuazione-domani.md`: cancellazione tenuta, ours l'ha rinominato in `.story.md` che ha gia' `qmd:`. README: link solo verso file esistenti | `a7434a2` |
| Modules/Tenant | 6 | ours: theirs portava un search-replace di massa (`index_generated.md` e `index-generated.md` → entrambi `index-generated-3.md`; `—` → `\|:` che rompe le tabelle). `api.md`: ours + `status: superseded` (target `../api.md` esiste) + link `best-practices.md` esistente. `ARCHITECTURE.md`: cancellazione accettata (collisione di case con `architecture.md`) | `cdf8f59` |
| Themes/Zero | 3 | due alias datati: conflitto di **mode**, tenuto il symlink (target esistente) invece del testo appiattito; story: link verso `xotbase-inheritance.md` (esiste) | `ec7e293f` |

Le modifiche non staged preesistenti di altri agenti in quei repo non sono state toccate.

## Non fatto: marker committati nei moduli lockati

Lock vivi `phpstan-zero-20261125-*` (agent-composer, 09:34) e story
`merge-conflict-markers-committed-bonifica` aperta alle 09:38 sullo stesso perimetro: nessuna modifica.

Diagnosi misurata (file con `<<<<<<< ` in HEAD di ogni repo modulo):

| Modulo | File | Origine (stato blob nei due genitori del commit `first`) |
|---|---:|---|
| Notify | 2475 | 2411 gia' corrotti nel lato `laraxot/dev`: **l'upstream ha marker committati** |
| User | 843 | 624 conflitti veri (genitori puliti), 219 da upstream corrotto |
| Activity | 232 | commit orfano unico, nessun remote: storia pulita solo nel repo root |
| Lang | 218 | idem |
| UI | 154 | 153 conflitti veri |
| Xot | 87 | 73 conflitti veri, 14 da upstream |
| Media | 80 | 80 conflitti veri |
| Job | 20 + merge aperto (35 unmerged) | merge 08:43 ancora aperto |

Tutti i commit `first` sono delle 08:38–09:07: merge committati senza risoluzione dallo script di sync
(root cause in `bashscripts/docs/stories/0031-0031-history-rewrite-real-guard.story.md`).

## Gate

- Marker e unmerged: 0 in Progressioni, Tenant, Themes/Zero.
- `php -l` sul solo PHP portato dal merge (Tenant test): ok.
- `phpstan analyse Modules/Tenant Modules/Progressioni`: exit 0, nessun errore.
- Pest: skip documentato — `TestDatabaseGuard` rifiuta il DB remoto `10.100.200.53` (protezione dati sacri).

## Acceptance criteria

- [x] Merge aperti Progressioni/Tenant/Zero chiusi con criterio verificabile
- [x] PHPStan verde sui moduli toccati
- [ ] Marker nei moduli lockati: in carico a `merge-conflict-markers-committed-bonifica` (solo PHP); i ~3500 `.md` restano senza owner
- [ ] Notify upstream `laraxot/dev` da bonificare alla fonte, altrimenti il prossimo sync li reintroduce


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
