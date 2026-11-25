---
title: "Session handoff — qualità continua LaravelPizza"
type: handoff
status: current
updated: 2026-11-25
qmd: "session handoff phpstan zero git slim docs ceiling prompts standing order bmad second brain"
related:
  - ./git-slim-report.md
  - ./wiki/second-brain/second-brain.md
  - ./ai-handoff.md
  - ../laravel/Modules/Xot/docs/bmad/stories/0148-phpstan-modules-zero-swarm-standing.story.md
  - ../laravel/Modules/Xot/docs/bmad/stories/0087-git-objects-slimming-independent-repos.story.md
---

# Session handoff — qualità continua

Copiare le sezioni sotto in una nuova chat per riprendere senza perdita di contesto.

## 1. Obiettivo principale

Mantenere e alzare continuamente la qualità di `base_laravelpizza_fila5`:

- `cd laravel && ./vendor/bin/phpstan analyse Modules` → **sempre 0**
- ogni `.git` dei path in `gitmodules.ini` → **&lt; 10.000 oggetti**
- docs moduli/temi ordinate (kebab, no date nei nomi, DRY, ceiling ≤100 md/owner)
- prompt in `bashscripts/docs/prompts` sempre migliorati
- codice clean / DRY / KISS; `mixed` solo ultima spiaggia; fix alla **sorgente** (scopo/perché), non sul sintomo
- coordinamento multi-agente via **BMAD stories** + **second brain** + ECC + Ponytail, senza chiedere conferma per boy-scout

## 2. Contesto e vincoli

- Progetto: LaravelPizza (meetup/community), Folio+Volt FO, Filament BO, moduli nwidart, XotBase, PHPStan level max
- Path root: `/mnt/nas07/var/www/_bases/base_laravelpizza_fila5`
- Repo indipendenti: path di [`gitmodules.ini`](../gitmodules.ini) (16: bashscripts + 14 moduli + Themes/Meetup). **Non** usare gitmodules classici: ogni path ha `.git` proprio (`laraxot/*_fila5`)
- Git: forward-only (no reset/force-push senza decisione esplicita); multi-repo commit/push nel repo owner
- Lingua: italiano con l’utente
- Ponytail full: ladder YAGNI, diff minimo dopo aver capito lo scopo
- Gate PHPStan ufficiale = `phpstan.neon` default, **mai** `-c` scratch come vittoria
- Test: Pest, niente `RefreshDatabase`; suite Project in Meetup
- `@see` → docs su ogni classe/metodo toccato; docs solo in cartelle `docs/` esistenti

### Standing order (sempre, senza conferma)

1. PHPStan 0 su `Modules`
2. Swarm random parallelo + BMAD + second brain
3. Studiare/aggiornare/organizzare docs moduli/temi
4. Migliorare `bashscripts/docs/prompts`
5. Slim git &lt;10k; report in [`git-slim-report.md`](./git-slim-report.md)
6. Coordinarsi con altri agenti via story BMAD

## 3. Decisioni prese e risultati raggiunti

### Git slim (2026-11-25 sera)

- **16/16** path `gitmodules.ini` &lt; 10.000 oggetti (rimisura ~20:52: max bashscripts 6192)
- Notify: 153523→~3730 via `bashscripts/git/slim-git-repos.sh --apply --shallow`
- Job/Tenant/Xot: depth-1 sul tip remoto (push da shallow falliva per parent mancanti)
- Canon tool: `bashscripts/git/slim-git-repos.sh` (non più `slim-module-theme-git.sh`)
- Report: [`docs/git-slim-report.md`](./git-slim-report.md)
- Story: [`0087`](../laravel/Modules/Xot/docs/bmad/stories/0087-git-objects-slimming-independent-repos.story.md)
- Backup: `~/backups/git-slim-20261125-wave2/*.git.tar.zst`
- Lezione: merge col tip remoto tiene raggiungibile tutta la storia del secondo parent anche con `.git/shallow` su un altro root

### PHPStan (2026-11-25 ~20:55)

- `./vendor/bin/phpstan analyse Modules` → **`file_errors: 0`** (7468 file; dopo clear-result-cache)
- Prima fatale: `Modules/AI/.../XotBaseCreateRecord.php` ridichiarava `Modules\Xot\...` — file poi sparito (altro agente / cleanup); cartella `AI/app/Filament/Resources/Pages` assente
- Story standing: [`0148-phpstan-modules-zero-swarm-standing`](../laravel/Modules/Xot/docs/bmad/stories/0148-phpstan-modules-zero-swarm-standing.story.md)

### Docs ceiling

- Era ≤100 per owner dopo wave mattina; **regressione misurata 20:55**: Notify **2448**, Cms 143, User 189, Xot 113, Activity 109, Meetup 91 (ok)
- Tool: `REPO_ROOT=$PWD python3 bashscripts/tools/docs/docs-ceiling-100.py --roots ... --apply`

### Altro

- Untracked “ahead” post-slim su Job/Tenant/Xot: **0** ora (ripuliti/committati altrove)
- `merge_remote_repo_2.sh` **non** è deprecato (sync principale); rewrite storia solo con `PTVX_ALLOW_HISTORY_REWRITE=1` oltre `MAX_GIT_OBJECTS=130000`

## 4. Dati o codice chiave (non rompere)

| Chiave | Valore |
|--------|--------|
| PHPStan cmd | `cd laravel && ./vendor/bin/phpstan analyse Modules` |
| PHPStan config | solo `laravel/phpstan.neon` (level max) |
| Slim cmd | `bash bashscripts/git/slim-git-repos.sh [--apply] [--shallow]` |
| Soglia oggetti | 10.000 locali; script sync ancora 130000 |
| Report slim | `docs/git-slim-report.md` |
| Second brain | `docs/wiki/second-brain/second-brain.md` → `git-objects-under-10k`, `docs-ceiling-100`, `phpstan-journey` |
| Prompts | `bashscripts/docs/prompts/` (12 file top-level aggregati) |
| Org remotes | `laraxot/*_fila5` |
| Theme public | symlink `public_html/themes/Meetup` → `Themes/Meetup/public` |
| belongsToMany | sempre `belongsToManyX` |
| Localization | `LaravelLocalization::localizeUrl` |

## 5. Prossimo passo (esatto)

1. **Docs ceiling regressione**: ripristinare ≤100 md su Notify (2448!), Cms, User, Xot, Activity — con `docs-ceiling-100.py`, digest overflow, no archive parallelo
2. **Tenere PHPStan a 0**: dopo ogni sync/`merge_remote_repo_2` rilanciare cold `clear-result-cache` + `analyse Modules`; se torna rosso, triage random per modulo e swarm
3. **Prompts**: audit/migliora `bashscripts/docs/prompts/*` (allineamento standing order story `0162`)
4. **Decisione aperta utente**: abbassare `MAX_GIT_OBJECTS` a 10000? (implica squash+force-push in sync)
5. **AI module**: presente e attivo ma non in `gitmodules.ini`; verificare che non reintroduca copie `Modules\Xot\*` sotto `Modules/AI/app`

## Come ripartire (checklist 60s)

```bash
cd /mnt/nas07/var/www/_bases/base_laravelpizza_fila5/laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse Modules --memory-limit=2G
# docs ceiling
cd .. && for m in Notify Cms User Xot Activity; do
  find laravel/Modules/$m/docs -name '*.md' | wc -l
done
# git slim spot-check
bash bashscripts/git/slim-git-repos.sh   # dry-run
```
