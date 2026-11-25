---
title: "Repo indipendenti di gitmodules.ini sotto 10000 oggetti git"
type: story
status: review
module: Xot
epic: quality-gates
story_id: git-objects-slimming-independent-repos
created: 2026-11-25
updated: 2026-11-25
qmd: "git count-objects 10000 oggetti slim shallow depth gc prune commit-graph stale tag semantic-release refspec prefetch gitmodules.ini repo indipendenti notify user xot ricrescita commit first sync"
related:
  - ./0105-module-theme-git-slim.story.md
  - ./0092-merge-conflict-markers-md-bonifica.story.md
  - ../../../../../../bashscripts/ai/wiki/memories/git-sync-fleet-remotes.md
---
# Repo indipendenti sotto 10000 oggetti git

## Context and Problem Statement

`bashscripts/git/subtrees/merge_remote_repo_2.sh` e' lo strumento di sync **in uso e funzionante**, non un bug da
eliminare (l'etichetta "DEPRECATO" del 2026-09-15 era errata). Contiene gia' il meccanismo di snellimento voluto:
`MAX_GIT_OBJECTS=130000` → `git_delete_history` (orphan commit `first` + push -f) + `git_deep_cleanup`, bloccati da
`_refuse_history_rewrite` senza `PTVX_ALLOW_HISTORY_REWRITE=1`. I commit `first` visti in Notify vengono da li'.
La ricrescita nasce dal merge `--allow-unrelated-histories` con copie dello stesso remoto che conservano la storia
vecchia (piu' progetti `base_*` condividono i remoti `laraxot/*`), non da un difetto dello script.

Leve reali, da decidere con l'utente:
- soglia `MAX_GIT_OBJECTS` 130000 vs obiettivo dichiarato 10000 (abbassarla = squash + force push alla prossima sync);
- `git maintenance` globale registra Activity/Lang/Media/Notify/UI/User/Xot di ptvx (prefetch di tutti i branch);
- `gitmodules.ini` dichiara `provtv/*`, i repo tracciano `laraxot/*` (lo script riscrive l'URL con l'argomento ORG).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

Follow-up di [module-theme-git-slim](0105-module-theme-git-slim.story.md) (24/11), non la sostituisce.

## Richiesta utente (verbatim)

«leggi gitmodules.ini tutti quei path hanno una cartella git separata, non voglio utilizzare git modules, va in quei
path e controlla la dimensione della sottocartella .git e quanti oggetti contiene, dobbiamo snellire quelle cartelle .git
dobbiamo scendere sotto i 10000 oggetti, molto probabilmente son da cancellare files che non andavano versionati, o ha una
storia troppo lunga o altro, analizza a fondo e fa tutto con bmad + ecc + second brain»

## Diagnosi (misurata, non presunta)

Metrica: `git count-objects -v` → `count + in-pack`. 23 path in `gitmodules.ini`, tutti con `.git` directory.

**Premessa utente verificata e in parte smentita:** nello snapshot HEAD i file "da non versionare" sono ~0
(pattern node_modules/vendor/graphify-out/cache/coverage/log/zip: 0 file in HEAD, Xot 2). Il peso e' nella **storia**:

| Causa | Evidenza |
|---|---|
| Spazzatura non raggiungibile nei pack | Activity 40182 in-pack vs 2079 raggiungibili; Lang 57634 vs 1720 |
| Commit `first` del sync (root orfani con l'intero tree) | Notify: 5 commit `first` in 2 giorni, ognuno +4600 file / +1,1M righe; root `250c490f6` del 24/11 20:35 |
| Churn `docs/` (rinomine/dedup/normalize ripetuti) | ultimi 20 commit Notify = 19048 oggetti, quasi tutti `docs/wiki`, `docs/ai-agents` |
| Host project committato nella storia del modulo | Notify: 43110 oggetti `laravel/Modules`, 7299 `laravel/Themes`, `node_modules` (non in HEAD) |
| Tag semantic-release | Rating 306, Zero 196: tengono viva tutta la storia |
| **Ricrescita dopo lo slim del 24/11** | Notify era a depth 1 / 15 MiB; il 25/11 e' di nuovo 152k oggetti / 432 MiB, non shallow |
| bashscripts: snapshot HEAD da solo 14784 oggetti | 13230 file; 7161 cancellazioni gia' in stage (altro agente) → post-commit ~7,7k |

## Fatto (fase 1: repo non lockati, allineati a `laraxot/dev`)

Backup integrale di ogni `.git` prima di tutto: `~/backups/git-slim-20261125/<repo>.git.tar.zst` (117 MiB, `zstd -t` ok).

1. `reflog expire --expire-unreachable=now --all` + `gc --prune=now` (bashscripts `--prune=1.hour.ago`: indice altrui).
2. Rating, Tenant, Zero (0 ahead / 0 behind): tag locali rimossi **solo dopo** verifica che tutti esistano sul remoto con
   lo stesso oggetto (306/2/196), ref remoti != `dev` rimossi, `remote.laraxot.fetch` = solo `dev`, `tagOpt --no-tags`,
   `maintenance.prefetch.enabled=false`, `fetch --depth=30` (Zero 100), `gc --prune=now`.
3. Commit-graph rigenerato (Rating/Tenant/Zero/bashscripts): dopo il prune elencava commit inesistenti (`fsck` 2337/1028/11220/48 righe).

| Repo | Prima | Dopo |
|---|---:|---:|
| Rating | 23116 | 4918 |
| Tenant | 17651 | 6230 |
| Zero | 22116 | 8878 |
| Ptv | 8778 | 7541 |
| IndennitaResponsabilita | 6889 | 5785 |
| Progressioni | 6699 | 5496 |
| Performance | 6252 | 5440 |
| Sigma | 5233 | 3659 |
| Incentivi / ICL / Pdnd / One / Three / noconsole | ≤3500 | ≤2888 |
| bashscripts | 21348 | 21040 |

Verifica: `fsck --connectivity-only` 0 errori su tutti i 15; HEAD, ahead/behind 0/0 e numero file dirty invariati;
indice di bashscripts intatto (7161 D in stage). **Recupero:** `git fetch --unshallow --tags laraxot` oppure restore del tar.

## Da fare (bloccato)

| Repo | Oggetti | Blocco | Azione quando libero |
|---|---:|---|---|
| Activity | 40186 | lock `markers-md-20261125-Activity` | solo `gc --prune=now` (raggiungibili 2079) |
| Lang | 57637 | lock `markers-md-20261125-Lang` | solo `gc --prune=now` (raggiungibili 1720) |
| Job | 34397 | lock + 2 ahead / 22 behind | push/sync, poi depth ~50 |
| Media | 32550 | lock + 638/3329 divergente | risolvere divergenza, poi shallow |
| UI | 62512 | lock + 645/852 | idem |
| User | 107702 | lock + 417/416 | idem (depth 1 = 5842) |
| Xot | 107190 | lock + 1323/1359 | idem |
| Notify | 152422 | lock + 34/442, ricresciuto | idem (depth 1 = 5106) |
| bashscripts | 21040 | commit in stage di altro agente | dopo il commit: `fetch --depth=1` |

Shallow con commit locali non pushati = push impossibile (il remoto riceverebbe commit con parent mancanti): precondizione
**HEAD == remote-tracking**, non negoziabile. `filter-repo` + force push e' l'unico modo per snellire il **remoto**: vietato
da forward-only, serve decisione esplicita del proprietario.

## Perche' ricresce (corretto il 2026-11-25 su indicazione dell'utente)

`bashscripts/git/subtrees/merge_remote_repo_2.sh` e' lo strumento di sync **in uso e funzionante**, non un bug da
eliminare (l'etichetta "DEPRECATO" del 2026-09-15 era errata). Contiene gia' il meccanismo di snellimento voluto:
`MAX_GIT_OBJECTS=130000` → `git_delete_history` (orphan commit `first` + push -f) + `git_deep_cleanup`, bloccati da
`_refuse_history_rewrite` senza `PTVX_ALLOW_HISTORY_REWRITE=1`. I commit `first` visti in Notify vengono da li'.
La ricrescita nasce dal merge `--allow-unrelated-histories` con copie dello stesso remoto che conservano la storia
vecchia (piu' progetti `base_*` condividono i remoti `laraxot/*`), non da un difetto dello script.

Leve reali, da decidere con l'utente:
- soglia `MAX_GIT_OBJECTS` 130000 vs obiettivo dichiarato 10000 (abbassarla = squash + force push alla prossima sync);
- `git maintenance` globale registra Activity/Lang/Media/Notify/UI/User/Xot di ptvx (prefetch di tutti i branch);
- `gitmodules.ini` dichiara `provtv/*`, i repo tracciano `laraxot/*` (lo script riscrive l'URL con l'argomento ORG).


## Esito finale (misura 2026-11-25 11:55)

Tutti i 23 repo sono shallow e sotto soglia. Il taglio a depth 1 degli 8 repo bloccati non e' di questa sessione: dai reflog
risulta fatto fra le 10:31 e le 10:42 (es. `Rating/.git/shallow` = `6adbe1b` delle 10:31, `Notify/.git/shallow` delle 10:42),
poi il sync `merge_remote_repo_2.sh` delle 11:36 (commit `.`) ha committato e pushato anche le bonifiche docs.

| Repo | Oggetti |
|---|---:|
| Notify | 9877 (al limite: primo a sforare) |
| User | 6493 |
| bashscripts | 6212 |
| UI | 2574 |
| Xot | 2919 |
| altri 18 | 21–1925 |

Attenzione: `MAX_GIT_OBJECTS` nello script resta 130000, quindi nessuna protezione automatica a 10000; Notify va rimisurato
dopo i prossimi sync.

## Acceptance criteria

- [x] Misura oggetti/dimensione per tutti i 23 path di `gitmodules.ini`
- [x] Diagnosi cause con evidenze
- [x] 15/23 repo < 10000 oggetti, `fsck` pulito, working tree e allineamento invariati, backup verificato
- [x] 23/23 repo < 10000 (misura 2026-11-25 11:55; vedi "Esito finale")
- [ ] Decisione utente su soglia `MAX_GIT_OBJECTS` (10000?) e sul prefetch di `git maintenance`

## Gate

Nessun file PHP toccato: PHPStan/Pint/Pest non applicabili (skip documentato). Gate = `fsck` + `count-objects`.

## Coordinamento

| Agente | Scope | Stato |
|---|---|---|
| claude-opus-5.5 f3659729 | fase 1 su 15 repo, lock `bashscripts/lock/git-slim-20261125-*` | 2026-11-25 done, lock rilasciati |
| claude-opus-5.5 8f1ecc86 | lock markers-md su 8 moduli | attivo, non toccato |


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
