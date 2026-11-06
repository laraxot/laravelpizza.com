---
title: "User: marker di conflitto git residui in docs/ (866 file): pulizia + aggiornamento indice"
type: story
module: User
epic: null
story_id: null
slug: docs-merge-conflict-markers-cleanup
status: done
cold_gate: null
created: '2026-09-22'
updated: '2026-09-22'
repository: "git@github.com:provtv/module_user_fila5.git"
github_issue: "https://github.com/provtv/module_user_fila5/issues/36"
github_discussion: "https://github.com/provtv/module_user_fila5/discussions/37"
estimated_effort: "2h"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "laravel/Modules/User/docs/"
---

# User: marker di conflitto git residui in docs/: pulizia + aggiornamento indice

## Contesto

Story figlia del follow-up second-brain segnalato (ma non eseguito) in
`uppercase-root-dirs-database-application.story.md`: "`Modules/User/docs/` ha
rumore evidente da ripulire in una story dedicata". Task delegato con lock
`laravel/Modules/User:docs` (non l'intero modulo: un'altra sessione lavorava
in parallelo su `Application/`/`Database/` a root modulo, esplicitamente
esclusi da questa story).

## Investigazione

Il comando di ricerca inizialmente suggerito
(`grep -rl '^<<<<<<< \|^=======$\|^>>>>>>> ' docs/`) dava troppi falsi
positivi: `^=======$` da solo intercetta anche le intestazioni Markdown in
stile setext (`Titolo\n=======`). Raffinato in
`grep -rlE '^<<<<<<< |^>>>>>>> ' docs/` per i candidati, poi verificato con
un classificatore ad adiacenza in Python: ogni riga `=======` rimasta in
`docs/` (22 occorrenze totali) è risultata adiacente (riga precedente o
successiva) a un marker `<<<<<<<`/`>>>>>>> `: 0 anomalie, nessuna
intestazione genuina scambiata per corruzione.

**Scala reale**: 866 file `.md`/`.mdc` su ~3399 in `docs/`, non i 5 elencati
nell'inventario storico 2026-04-28 in
`docs/wiki/troubleshooting/git-merge-conflict-inventory.md`. Causa
identificata: quell'inventario (stato 2026-07-08, "0 marker") rigenerava la
lista con `git grep -l '^<<<<<<<'`: cieco ai marker `>>>>>>> ` orfani senza
apertura corrispondente, la classe di corruzione reale qui.

Pattern di corruzione: marker `>>>>>>> <ref> (.)` (varianti `87273113`,
`2024e2e7`, `60a2c9a9`, `f548be94`, `laraxot/dev`) senza `<<<<<<<` di
apertura: probabile artefatto di un processo di commit "." precedente che
aveva già rimosso l'apertura lasciando `=======`/`>>>>>>> ` orfani a livello
di riga grezza (confermato presente anche dentro fence di codice, quindi
processo non markdown-aware). Confermato **committato**, non un merge locale
in corso: `git show laraxot/dev:<path>` mostra gli stessi marker sul tip del
branch remoto.

## Classificazione e risoluzione

**10 conflitti genuini a 3 vie** (contenuto reale su entrambi i lati),
risolti a mano fondendo senza perdita di informazione:

- 7 casi banali HEAD/dev entrambi vuoti → sola rimozione marker.
- `docs/wiki/skills/INDEX.md` e `docs/wiki/skills/index.md`: entrambi i lati
  non identici (link a varianti case-diverse dello stesso file) → tenuti
  entrambi i bullet, rimossi solo i marker.
- `docs/stories/user-passport-create-client-credentials-button.md`: lato
  dev (più lungo, datato, verificato con query diretta) confuta esplicitamente
  un'ipotesi lato HEAD di una riga → tenuto il lato dev, scartato il
  frammento HEAD superato.

**856 file di rumore orfano puro**, risolti con script Python deterministico
(non manuale: scala incompatibile con revisione per-file):

1. Rimuove ogni riga che combacia con `^<<<<<<< .*$` o `^>>>>>>> .*$`.
2. Rimuove una riga `^=======$` solo se adiacente (prima o dopo) a una riga
   marker.
3. Dopo la rimozione, collassa una riga duplicata immediatamente adiacente
   **solo se** una riga è stata rimossa fra le due occorrenze identiche
   (pattern "riga di chiusura duplicata attorno al divisore a fine
   documento": es. `docs/xotbasemigration-laraxot.md`: la stessa riga
   `**Ricorda: XotBaseMigration è Dio. Non deviare.**` appariva prima e dopo
   il blocco di marker).

Risultato: 1384 righe marker rimosse, 68 righe duplicate collassate (48
righe vuote coincidentali, 20 cluster di contenuto reale duplicato attorno
al divisore: verificati a campione, nessun caso di contenuto legittimamente
ripetuto per enfasi scambiato per corruzione).

## Verifica

```
grep -rlE '^<<<<<<< |^=======$|^>>>>>>> ' docs/   # 0 file
```

Verificati anche i 10 file già corretti a mano prima dello script bulk: 0
marker residui in tutti, script non li ha ritoccati.

## Root-md-files e index

`docs/root-md-files/*.md` (7 file: changelog.md + 2 varianti numerate,
git-reset.md + 1 variante, pest-test-report.md, philosophy.md) verificato
pulito: nessun artefatto tipo `(.)` a fine riga, nessuna intestazione H1
duplicata.

`docs/index.md` (indice auto-generato, 3419 righe) aveva la sezione
`## root-md-files` disallineata: elencava solo 2 dei 7 file `.md` presenti
(`git-reset.md`, `pest-test-report.md`), mancavano `changelog.md`,
`changelog-1.md`, `changelog-2.md`, `git-reset-1.md`, `philosophy.md`.
Corretta chirurgicamente (solo quella sezione, non rigenerazione completa -
fuori scope per questa story).

`docs/00-index.md`, `docs/README.md`, `docs/purpose.md`: verificati, nessun
riferimento stale a path root-modulo rimossi (`PHILOSOPHY.md`,
`CHANGELOG.MD`, ecc.).

## Esclusioni deliberate

- Duplicati case-only (`INDEX.md`/`index.md`, `00-INDEX.md`/`00-index.md`,
  ecc.): problema noto e già tracciato in `docs/case-conflicts.md`
  (issue #124, discussion #1). Non consolidato qui: richiede aggiornamento
  riferimenti a livello di progetto, story separata.
- `Application/`/`Database/` a root modulo: riservato all'altra sessione
  (`uppercase-root-dirs-database-application.story.md`, status `done`).
- Un file (`docs/stories/uppercase-root-dirs-database-application.story.md`)
  è stato trovato modificato in working tree da quella sessione parallela
  durante l'esecuzione di questa story (status `blocked` → `done` + nota
  finale): **escluso esplicitamente** dallo staging di questo commit
  (verificato via parsing del diff: unica modifica fra 867 file con
  inserimenti non riconducibili allo script di pulizia marker).

## Second brain aggiornato

`docs/wiki/troubleshooting/git-merge-conflict-inventory.md`: aggiunta
sezione "Stato 2026-09-22" con causa della recidiva e correzione del comando
di rilevazione (`grep -rlE '^<<<<<<< |^=======$|^>>>>>>> '` al posto di
`git grep -l '^<<<<<<<'`, che copriva solo l'apertura).

## Dev Agent Record

Lock `laravel/Modules/User:docs` acquisito e rilasciato correttamente
(scope limitato a `docs/`, non l'intero modulo). Commit unico, 867 file
(`git add` con lista esplicita di path, mai `-A`: repo con ~5000
modifiche non correlate di altre sessioni in corso).