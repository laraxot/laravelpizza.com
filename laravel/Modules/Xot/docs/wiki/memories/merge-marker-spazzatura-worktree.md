---
title: "Marker di merge: spazzatura nel worktree, non in HEAD"
type: memory
tags: [merge, marker, worktree, phpstan, bootstrap, multi-agent, git]
created: 2026-09-28
updated: 2026-09-28
qmd: "marker di merge spazzatura worktree git grep HEAD parse error service provider blocca phpstan pest artisan"
related:
  - ../../bmad/stories/5.248-phpstan-modules-gate-blocked-merge-wip.story.md
  - ./bmad-module-documentation-baseline.md
  - ./index.md
issues: []
discussions: []
status: draft
---

# Marker di merge: spazzatura nel worktree, non in HEAD

> **SUMMARY**: i marker `<<<<<<<` che fanno morire PHPStan, Pest e `artisan`
> possono essere **spazzatura iniettata nel worktree** da un merge abortito e
> **non risultano in nessun comando git normale**. Il rilevamento affidabile e
> `git grep` su `HEAD`, non `git status`.

## Sintomo

```
Error: syntax error, unexpected token "<<", expecting "function"
Application bootstrap failed
```

con `git ls-files -u` = 0, nessun `.git/MERGE_HEAD`, nessun rebase in corso, e
`git status` che mostra solo ` M` (modified, non unmerged). Il messaggio cambia a
ogni run e i marker appaiono e spariscono: **il worktree viene riscritto sotto i
piedi**.

## Perche' blocca tutto il monorepo

Un solo file `.php` con marker dentro un **service provider** uccide ogni
comando che boota Laravel, indipendentemente dallo scope analizzato:

- `phpstan analyse Modules/Qualcosa` muore prima di analizzare;
- `pest --no-coverage` muore prima di raccogliere i test;
- `php artisan --version` muore.

Ecco perche' `phpstan analyse` con `--level` diversi o path diversi fallisce
uguale: il problema e nel bootstrap, non nel codice analizzato.

## La procedura corretta

1. **Distingui HEAD da worktree** (il punto che genera piu' errori di diagnosi):

   ```bash
   git grep -l '^<<<<<<<' HEAD -- 'laravel/Modules/*.php' | wc -l
   ```

   Se `0` e il worktree ha marker, sono rumore locale, non codice del progetto.

2. **Conta e classifica i file**:

   ```bash
   grep -rlE '^(<{7}|={7}|>{7})' --include='*.php' laravel/Modules | wc -l
   ```

3. **Verifica che HEAD sia sintatticamente valido** prima di ripristinare:

   ```bash
   git show HEAD:<path> > /tmp/prova.php && php -l /tmp/prova.php
   ```

   Se il file e rotto anche in HEAD, il restore non risolve niente.

4. **Ripristina per scrittura esplicita**, mai con comandi che toccano index o
   history:

   ```bash
   git show HEAD:<path> > <path>      # NO git checkout --, NO git restore
   ```

   Con backup tarball prima (`tar czf /tmp/backup-$(date +%Y%m%d-%H%M%S).tar.gz ...`).

5. **Non fidarti del solo hunk**: un hunk con marker non e sempre rumore.

   | Tipo di hunk | Risoluzione corretta |
   |---|---|
   | Un lato vuoto | tenere il lato non vuoto |
   | Due lati identici | una sola copia |
   | Due lati diversi ma equivalenti (formattazione) | ripristinare da HEAD |
   | `lang/**.php` (array di traduzione) | **unione delle chiavi**: HEAD prima, poi le nuove, dedup |
   | `app/`, `tests/`, `config/`, `database/` | valutare con `php -l` e verifica dei simboli referenziati |

6. **Verifica il parse a tappeto** prima di rilanciare i gate:

   ```bash
   cd laravel && ./vendor/bin/parallel-lint --exclude vendor --exclude .git Modules
   ```

7. **Riprova con cache fredda**, altrimenti un risultato 0 puo' essere un no-op:

   ```bash
   mkdir -p /tmp/phpstan/cache/nette.configurator   # PHPStan non ricrea le dir
   php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --no-progress
   ```

   Conferma che l'analisi sia avvenuta davvero controllando la dimensione della
   cache risultante (un run reale su questo monorepo lascia ~330M / ~16k file).

## Concorrenza: il vero rischio

Su questo repository piu agenti scrivono nello stesso worktree. Prima di ogni
batch di edit:

```bash
find laravel/Modules -name '*.php' -newermt '-3 minutes' -not -path '*/vendor/*' | wc -l
```

Se il numero non e `0`, **non editare**: stai per scrivere sopra il lavoro di
qualcun altro. Cause osservate di riscritture massive: `git lfs migrate
export --everything -y` e trasferimenti `git-lfs-transfer` in corso.

## Correzione delle diagnosi precedenti

La documentazione di questo progetto affermava *"i marker sono committati, git
non li segnala come unmerged"*. **Falso**: `git grep` su `HEAD` era pulito in
tutte le verifiche. La verifica sul codice batte la documentazione.

## Regola

> Un marker di merge che `git status` non segnala e che `git grep HEAD` non
> trova va trattato come rumore del worktree: verificare con `php -l`, fare
> backup, ripristinare da `git show`, e **non** "risolvere il conflitto" a mano
> su file che non ho scritto.

## Quando NONApplicare

- Il file e rotto anche in `HEAD` (verificato con `php -l`): il restore non
  aiuta, serve una story separata.
- Il file e in `docs/`: `phpstan.neon` esclude `./*/docs/*`, quindi e innocuo per
  il gate (ma non per `pint` o per la ricerca testuale).
- Il file e `lang/**.php`: serve l'unione delle chiavi, non il restore.