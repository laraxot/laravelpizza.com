---
title: "Snellire .git di moduli e temi"
type: story
status: review
module: Xot
epic: quality-gates
story_id: module-theme-git-slim
updated: 2026-11-25
tags: [git, slim, gc, shallow, commit-graph, multi-repo]
qmd: "git slim module theme refs original prefetch remote-tracking tag stash shallow depth-1 commit-graph symref gc prune grace notify fsck non riscrivere storia"
related:
  - ../../../../../../bashscripts/docs/operations/module-theme-git-slim.md
  - ./0139-phpstan-modules-bootstrap-duplicate-lines.story.md
---
# Story — Snellire `.git` moduli/temi

## Context and Problem Statement

Ogni `Modules/*` e `Themes/*` e' un repo indipendente (`git remote -v`).
Dopo sync/`unrelated histories` i `.git` locali si gonfiano di oggetti
monorepo (path `laravel/`, `node_modules/`, altri moduli) anche se il
remoto owner e' piccolo. `git gc` non basta se gli oggetti sono raggiungibili.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Richiesta utente (verbatim, base_ptvx_fila5)

«controlla  e sistema  le cartelle .git dei moduli e dei temi han troppi elementi dentro salvati devono essere piu' slim e
probabilmente stanno tenendo delle cose che non serve tenere , fa tutto con bmad + second brain»

## Why

Ogni `Modules/*` e `Themes/*` e' un repo indipendente (`git remote -v`).
Dopo sync/`unrelated histories` i `.git` locali si gonfiano di oggetti
monorepo (path `laravel/`, `node_modules/`, altri moduli) anche se il
remoto owner e' piccolo. `git gc` non basta se gli oggetti sono raggiungibili.

## Esito misurato in base_ptvx_fila5 (2026-11-24, 21 repo: 18 moduli + 3 temi)

Totale `.git`: **613 → 143 MiB**. Verifica indipendente dallo script, su tutti i 21 repo, contro un'istantanea presa prima:
HEAD, hash dei branch locali, tip di `refs/stash` e numero di file modificati **identici**; `git fsck --connectivity-only` pulito.

| Repo | Prima | Dopo | Cosa pesava |
|------|------:|-----:|-------------|
| Notify | 432 | 15 | 1940 commit di storia sotto HEAD (vedi "Taglio della storia") |
| User | 38 | 9 | `laraxot/main` + duplicato in `refs/prefetch`, `refs/original` |
| Xot | 30 | 29 | quasi tutto e' storia vera di HEAD |
| UI | 28 | 21 | tag e ref remoti (12,6 MiB tenuti solo dai tag), `refs/original` non rimovibile |
| Activity | 16 | 4 | ref remoti e `refs/original` |
| Lang | 12 | 10 | ref remoti, tag |
| Media | 8 | 6 | ref remoti |
| altri 14 | 1-8 | invariati o −0..1 | gia' snelli |

Cosa e' stato tolto (solo cio' che si riscarica o e' gia' coperto da altro):
- `refs/prefetch/*` e `refs/remotes/laraxot/*` tranne `dev` e `HEAD`;
- `refs/original/*` in 10 repo dove ogni oggetto era gia' raggiungibile da altri ref (`rev-list` vuoto); negli 11 repo dove
  tenevano oggetti unici (Rating 213 ref, Progressioni 171 oggetti, Sigma 78, Pdnd 18...) sono rimasti;
- 4 tag (Tenant 2, Rating 2), solo perche' il remoto ha lo stesso nome **e** lo stesso oggetto;
- refspec di fetch di `laraxot` ristretto a `+refs/heads/dev:refs/remotes/laraxot/dev`, `maintenance.prefetch.enabled=false`:
  senza queste due cose `git maintenance` rigenera tutto.

Non toccati: branch locali, `refs/stash` (Xot, User), tag solo locali, working tree, URL dei remote, remoto.

## Taglio della storia di Notify (passo manuale, non nello script)

`git fetch --depth=1 laraxot <HEAD>` + `gc --prune=now`: **428 → 15 MiB**, 1940 → 1 commit, tree di HEAD invariato (4617 file),
3119 file modificati del working tree intatti, `fsck` pulito. Precondizioni verificate, non presunte:
HEAD == `laraxot/dev` locale; nessun commit solo locale; il remoto ha servito il commit per SHA (quindi ha anche tutti gli
antenati). Provato prima su una copia del `.git` in scratchpad. **Recupero:** `git fetch --unshallow laraxot` (~431 MiB).
Il remoto aveva nel frattempo un tip piu' avanti (`fddd1d09b`): il taglio e' stato fatto sul commit di HEAD, non sul tip,
perche' spostare il branch richiederebbe un `reset`, vietato.

## Procedura (sostituisce quella precedente di questa story)

```bash
bash bashscripts/tools/git/slim-module-theme-git.sh            # dry-run: PLAN per ogni repo
bash bashscripts/tools/git/slim-module-theme-git.sh --apply Notify User
```

Il passo `reflog expire --expire=now` della versione precedente e' stato tolto: svuota le voci vecchie di `git stash list`.
Il re-clone per ogni repo "inquinato" e' stato tolto dallo script: in User i due genitori del merge `c492fc0fb` non hanno
merge-base (`git merge-base` vuoto, 40 file su 40 campionati add/add): una storia locale senza antenato comune con
`laraxot/dev` e' la causa dei marker di merge, e un re-clone per ref non la sistema. Il taglio su Notify e' diverso: li' HEAD
coincide con `laraxot/dev`, quindi il merge-base esiste.

## Incidenti e lezioni

- **Due `FAIL` al primo `--apply` (Rating, UI), nessun dato perso.** Entrambi difetti dello script, corretti e provati:
  - UI: `refs/remotes/laraxot/HEAD` era un symref verso `laraxot/develop`, che avevo cancellato; `fsck` rc=2.
    Ora lo script lo riposiziona su `dev`.
  - Rating: la catena `commit-graph` (28 set) elencava 73 commit eliminati dal prune; `fsck` rc=16. In un repo shallow git non
    usa ne' riscrive il commit-graph, quindi `commit-graph write` esce 0 senza scrivere nulla (mi ha ingannato). Ora lo
    script elimina la catena se `commit-graph verify` fallisce.
  - Prova: repo di scratch con entrambi i difetti; la copia con la logica vecchia da `fsck` rc=18, lo script corretto rc=0.
- **Il `gc` non libera subito.** Dopo un `gc` appena fatto gli oggetti irraggiungibili hanno meno di un'ora e
  `--prune=1.hour.ago` li tiene: Notify e' passato da 428 a **444 MiB** prima di scendere a 15 con `--prune=now`.
  `--prune=now` solo con nessun git attivo nel repo (le voci dell'index contano come raggiungibili).
- **Contato male lo stash.** `git stash list` legge il reflog, che era vuoto: sembrava che Xot e User non avessero stash,
  ma `refs/stash` c'era e ha lo stesso hash di prima.
- **Non posso escludere di aver perso voci vecchie del reflog di stash.** I due `--apply` sono stati lanciati prima che lo script
  passasse `gc.reflogExpire=never`, e `git gc` applica da solo 90/30 giorni. Indizio contrario: nella misura precedente ai due
  `--apply` i reflog di HEAD erano gia' a 0 righe quasi ovunque (User compreso, che alle 21:11 ne aveva uno): qualcuno li aveva
  gia' svuotati. Il reflog dello stash non l'avevo misurato. Lo script ora conserva i reflog.
- **Ho sostituito lo script del 21:32** (`slim-module-theme-git.sh`, 122 righe, non tracciato quindi non recuperabile da git).
  Non l'ho eseguito, l'ho letto: cancellava tutti i tag, faceva `reflog expire --expire=now` e `gc --prune=now` senza controlli e
  non verificava che i ref rimossi fossero coperti altrove. Se serviva qualcosa di quella versione, il testo e' nella cronologia
  di questa sessione.

## Acceptance criteria

- [x] Ogni rimozione e' coperta da una prova (ref gia' raggiungibili da altro, o tag identici sul remoto).
- [x] HEAD, branch, `refs/stash` e file modificati identici prima/dopo su 21 repo.
- [x] `fsck --connectivity-only` pulito su 21 repo.
- [x] Lo script e' idempotente: secondo `--apply`, 21 su 21 `OK`, exit 0.
- [ ] Rating, UI, Progressioni e altri 8 con `refs/original` non rimovibile: decidere con il proprietario se i 213 ref di Rating
  servono ancora (non decido io: contengono oggetti che non esistono altrove).
- [ ] Il remoto `laraxot/module_notify_fila5` pesa ancora ~431 MiB di storia: si risolve solo li' (riscrittura), fuori scope.
- [ ] Nessun guard automatico: se i `.git` ricrescono (sync a storie non correlate, `git maintenance`) lo slim va rilanciato.

## Inventario base_laravelpizza_fila5 (progetto fratello, dichiarato dall'altra sessione, non verificato qui)

| Path | .git ~MB | Note |
|------|----------|------|
| Notify | ~14 (was ~428-461) | depth-1 `--single-branch` tip `c642ea4 first`; bak `.git.polluted.bak.202611241827` tenuto |
| Themes/Meetup | ~65 | PDF manuale + `repo.bundle` tracciato (~5 MB) |

## Coordinamento

| Agente | Scope | Claim |
|--------|-------|-------|
| coordinator | inventario + gc safe (skip Notify/Job sync) → 740→736MB | 2026-11-24 18:10 done |
| coordinator | Notify pollution diagnostic (1930 vs 1 commit remoto) | 2026-11-24 18:12 done |
| coordinator | Activity `.git-rewrite` rimosso | 2026-11-24 18:13 |
| lane-notify-reclone | Notify slim: wait sync → full clone (= remoto polluto 431MB/1930) → depth-1 14MB/1; bak polluted kept; no force-push | 2026-11-24 18:31 done |
| claude-fila5 | base_ptvx_fila5: slim 21 repo 613→143 MiB, script riscritto con gate fsck, Notify depth-1 sul HEAD | 2026-11-24 23:12 review |

## Verify

```bash
cd laravel && du -sm Modules/*/.git Themes/*/.git | sort -nr
for d in Modules/* Themes/*; do git -C $d fsck --connectivity-only --no-progress >/dev/null 2>&1 || echo "KO $d"; done
```

## Misura 2026-11-25 — target < 10.000 oggetti per repo

Metodo applicato (solo oggetti non raggiungibili, nessun `reset --hard`/`filter-repo`):
`git reflog expire --expire=now --all` + `git gc --prune=now`; dove la storia era gia'
troncata, boundary shallow riportato a HEAD; rimossi ref remoti non-`dev` e tag
identici al remoto; `commit-graph` rigenerato se `fsck` segnalava commit potati.

| Repo | Oggetti prima | Dopo | `.git` dopo |
|------|--------------:|-----:|------------:|
| Notify | 152.419 | 8.958 | 15 MB |
| bashscripts | 21.040 | 6.065 | 26 MB |
| User | 107.699 | 5.686 | 7 MB |
| Xot | 107.187 | 2.867 | 6 MB |
| UI | 62.507 | 2.470 | 18 MB |
| Media | 32.547 | 1.211 | 4 MB |
| Lang | 57.634 | 1.700 | 5 MB |
| Activity | 40.182 | 1.421 | 4 MB |
| Job | 32.060 | 1.285 | 2 MB |
| Tenant | 15.869 | 765 | 2 MB |
| Themes/Zero | 21.408 | 521 | 2 MB |
| Altri 12 path | — | 89-1.600 | 1-4 MB |

Gate: `git fsck --connectivity-only` pulito su tutti; `git status` e HEAD invariati.

<<<<<<< HEAD
<<<<<<< HEAD
## Misura base_laravelpizza_fila5 (2026-11-25 16:30)

Stesso obiettivo su questo clone (16 path in `gitmodules.ini`). Dettaglio in
[0087-git-objects-slimming-independent-repos.story.md](0087-git-objects-slimming-independent-repos.story.md).

Esito: **14/16 < 10000**. Bloccati: `Job` (`MERGE_HEAD`), `Notify` (`merge_remote_repo_2.sh` in corso, pack ~431 MB).
Lezione: `gc --prune=now` a volte lascia pack con oggetti irraggiungibili (`prune-packable: 0`) → serve
`repack -Ad` + `prune --expire=now`. Xot: tip remoto ≠ SHA locale → depth-1 via fetch fallisce; shallow locale su HEAD ok.

=======
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
## Correzione 2026-11-25 — `merge_remote_repo_2.sh` non e' deprecato

L'utente usa `merge_remote_repo_2.sh` come strumento di sync principale e ha chiesto
di non etichettarlo deprecato. Verificato sul codice: per ogni path fa commit `"."`,
fetch/merge `<ORG>/dev` (`--allow-unrelated-histories`, prima `-s resolve`) e push;
**nessun hard-stop runtime**. La riscrittura storia scatta solo oltre
`MAX_GIT_OBJECTS=130000` ed e' opt-in (`PTVX_ALLOW_HISTORY_REWRITE=1`). Corretti
header dello script, `bashscripts/docs/operations/subtrees-scripts-index.md` e
`docs/adr/0004-independent-repository-sync.md`; resta l'avvertenza di chiudere i merge
aperti prima di rilanciare (il commit `"."` li pubblicherebbe).

## Related

- [how-to](../../../../../../bashscripts/docs/operations/module-theme-git-slim.md)
- [git-repositories-slim-audit](0088-git-repositories-slim-audit.story.md) — passo parallelo (`gk`, `lfs`, `REBASE_HEAD`), con cui questa story
  diverge su Notify (dichiarato li')
- [nested-git-slim-hygiene](../../../../../../bashscripts/ai/wiki/memories/git-sync-fleet-remotes.md#nested-git-slim-hygiene) — memoria condivisa, con le lezioni di questa story
- [multi-repo map](../../../../../../bashscripts/ai/wiki/rules/git-workflow.md)
- [git-push-pack-errors](../../../../../../bashscripts/ai/wiki/rules/git-conflicts-merge.md)
- [cleanup-git-rewrite-artifact](0046-cleanup-git-rewrite-artifact.story.md)
- [phpstan bootstrap e marker](0139-phpstan-modules-bootstrap-duplicate-lines.story.md)
- [phpstan standing](0148-phpstan-modules-zero-swarm-standing.story.md)


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
