---
id: git-config-files-collision-sweep
title: Sweeper file git (.gitattributes/.gitignore/composer.json) da collisioni e fully PHPStan Modules
type: story
module: Xot
epic: code-quality
epic_name: "Quality gates e coordinamento swarm"
status: review
created: 2026-11-16
updated: 2026-11-16
tags: [bmad, phpstan, git, gitattributes, gitignore, composer, swarm, second-brain]
qmd: "gitattributes gitignore composer json merge conflict markers phpstan modules swarm"
---

# Obiettivo

Richiesta utente 2026-11-16: eseguire `phpstan analyse Modules`, sistemare tutte
le segnalazioni (swarm + subagent + BMAD + second brain, ordine random, focus su
scopo/perche' del codice), migliorare i prompt in `bashscripts/docs/prompts`,
riorganizzare le cartelle `docs` di moduli e temi, e sistemare/migliorare tutti
i `.gitattributes`, `.gitignore` e `composer.json` contenenti collisioni git.
Git LFS NON si usa in questo progetto.

# Stato verificato 2026-11-16 (baseline)

- **PHPStan full-tree**: piu' run in volo da altre sessioni
  (`/tmp/phpstan_ptvx_fila5/full.json`, `phpstan-user-full.txt`,
  `phpstan-modules-152128.txt`). Bug bootstrap risolto da altri agenti
  (marker `<<<<<<<` e `use` duplicato in Activity erano residuo merge
  salvato a meta', vedi wiki `phpstan-modules-swarm.md`).
- **Activity module**: file PHP con parse error attivi
  (`Activity.php`, `lang/it/activity.php`, `lang/it/snapshot.php`,
  `ActionsTest.php`, `StoredEventBusinessLogicTest.php`,
  `SnapshotsTable.php` use duplicato) — agenti LIVE sul modulo
  (77 file toccati in 15 min). NON toccare: scope di un'altra lane.
- **Collisioni git files**:
  - `laravel/Modules/Notify/composer.json` aveva marker `.merge_file_*`
    (merge-file driver) — RISOLTO da altro agente alle 15:21:53
    (tenuto il lato B a 4 spazi con require esteso: nyholm/psr7,
    mailtrap, resend, symfony 8.1, mailgun, zbateson).
  - `public_html/noconsole/composer.json` = 0 byte MA tracciato dal
    commit iniziale "let's start": placeholder legittimo dello strumento
    noconsole, NON una collisione. Lasciato.
- **LFS**: nessun `.gitattributes` usa `filter=lfs`/`diff=lfs`/`merge=lfs`
  come attributo — solo commenti "Mai: filter=lfs". Regola
  `no-git-lfs` gia' applicata repo-wide (26 file .gitattributes,
  pattern `binary !filter`). Verificato con `rg` sugli attributi attivi.
- **.gitignore**: 117 file, zero marker di collisione.
- **Working tree**: ~7454 file modificati non committati (Notify 3725,
  UI 2733, User 2078, Job 1233, Activity 1006, Media 608, Rating/Tenant 585)
  — WIP massivo di lane parallele (refactoring Actions/Datas/Contracts).

# Acceptance criteria

- [ ] Baseline PHPStan `analyse Modules` completo e JSON parsato;
      errori raggruppati per identificatore/causa radice.
- [ ] Errori PHPStan risolti per modulo con lane disgiunte e lock;
      gate finale `analyse Modules` a 0 errori o eccezioni documentate.
- [ ] `.gitattributes`/`.gitignore`/`composer.json`: zero collisioni,
      zero LFS, JSON validi (o eccezioni documentate come noconsole).
- [ ] Prompt `bashscripts/docs/prompts`: duplicati/alias verificati
      contro INDEX.md/MANIFEST.md; miglioramenti solo dove serve
      (story `docs-prompts-reorganization` e' gia' in review).
- [ ] Docs moduli/temi: controlli mirati (naming kebab-case senza date,
      frontmatter, indice), nessuna cancellazione senza verifica link.
- [ ] Aggiornamento `docs/sprint-status.yaml` + `qmd update` +
      `graphify update .` a fine lavoro.

# Note operative

- Cache PHPStan: MAI `rm -rf /tmp/phpstan` mentre altri agenti girano
  (cache condivisa = errori fantasma, vedi wiki phpstan-modules-swarm).
- PHPStan si lancia da `laravel/` con `php -d memory_limit=2G`,
  stesso `phpstan.neon`, MAI `-c`/`--level`/neon per-worker.
- Lock: `bashscripts/lock/lock.sh <file>` prima di ogni edit condiviso.
- Git LFS vietato: binari = blob normali (`binary !filter`).

# Esito 2026-11-16

## File git (scope esplicito utente)

- `.gitattributes`: 26 file verificati — NESSUN attributo LFS attivo
  (`filter=lfs`/`diff=lfs`/`merge=lfs` compaiono solo nei commenti
  "Mai:"). Pattern `binary !filter` gia' applicato repo-wide.
- `.gitignore`: 118 file, zero collisioni, policy date-docs e
  `phpstan*` ancorata gia' documentata e corretta.
- `composer.json`: 26 file validati con `json_decode` — tutti OK.
  Unica collisione reale trovata: `Modules/Notify/composer.json`
  (marker `.merge_file_*`), risolta dallo swarm alle 15:21:53
  tenendo il lato con `require` esteso.
- `public_html/noconsole/composer.json` = 0 byte ma tracciato dal
  commit iniziale: placeholder legittimo, non toccato.

## PHPStan Modules — baseline indipendente (4 lane, ordine random)

Snapshot 15:30-15:50, `phpstan.neon` unico, raw format:

| Modulo | Errori | Note |
|--------|--------|------|
| Activity | 112 | lane attiva (test mancano `use` Assert/TestCase/User) |
| UI | ~110 | `Modules\Geo\Models\Comune` inesistente + `LocationSelector.php` cancellato dallo swarm 15:39 |
| Media | 2 | `TestCase` non risolto nei test — fix live 15:37 |
| Ptv | 1 | `instanceof` sempre-true — fix live 15:39, **riverificato 0** |
| tutti gli altri 15 | 0 | Rating, Xot, Pdnd, Incentivi, User, Performance, Lang, Job, Sigma, IndennitaCondizioniLavoro, IndennitaResponsabilita, Progressioni, Notify, Tenant |

Tutti i cluster residui erano sotto riparazione attiva da altre lane
al momento della misura: nessun edit mio su file altrui (regola
scope disgiunti + lock).

## Prompt e docs

- `bashscripts/docs/prompts`: zero collisioni reali — i 15 file con
  stringhe `<<<<<<<` le usano come oggetti di studio (comandi di
  detection), non marker risolti. Alias/redirect system gia' sano.
- Residui noti della story `prompts-audit.story.md` (nomi underscore/
  maiuscoli, `START1.md`, `README_phpstan1.md`, copie divergenti
  `docs1-4`, `global_context.md`) appartengono alla story
  `docs-prompts-reorganization` in review con agente attivo sui file
  (mtime < 2h): non toccati per non collidere.
- Docs moduli/temi: story `docs-prompts-reorganization` copre gia'
  inventario e indici canonici.

## Gate

- PHPStan Ptv post-fix swarm: exit 0.
- `git diff --check` non applicabile (nessun edit codice mio).
- `qmd update` eseguito su fine sessione.

## Esito finale PHPStan (2026-11-16)

- Gate completo `cd laravel && ./vendor/bin/phpstan analyse Modules`:
  **0 errori su 10.669 file** (banner `[OK] No errors`, exit 0).
- I 7 errori `Activity/tests/` riportati dall'utente erano una snapshot
  stale: le lane Activity li ha risolti fra la run dell'utente e la
  riverifica (variabili `$action` inutilizzate, cast `mixed→string`,
  closure Pest vuote — fix con assert reali e `is_scalar()`).
- Verifica per-modulo `analyse Modules/Activity` raw: 0 errori.

## Audit modulare per moduli (nuova richiesta utente)

- Lanciati 6 subagent in parallelo (scope disgiunti per modulo) per
  audit profondo + documenti BMAD in `Modules/<Mod>/docs/bmad/`:
  - A: Activity, Job, Lang
  - B: Incentivi, Media, Notify
  - C: IndennitaCondizioniLavoro, IndennitaResponsabilita, Pdnd
  - D: Performance, Progressioni, Sigma
  - E: Ptv, Rating
  - F: Tenant, UI, User, Xot
- Ogni agente: audit statico (struttura, mixed, property_exists,
  phpstan-ignore, Filament no-labels/Xot base, test, i18n, marker merge,
  md con date) + story `module-bmad-audit.story.md` canonica.
<<<<<<< HEAD
- Moduli con story datata `module-bmad-audit-xot-baseline-analisi-completa.story.md` da
=======
<<<<<<< .merge_file_qpprDm
- Moduli con story datata `module-bmad-audit-baseline.story.md` da
=======
- Moduli con story datata `module-bmad-audit-xot-baseline-analisi-completa.story.md` da
>>>>>>> .merge_file_34Ec4N
>>>>>>> laraxot/dev
  rinominare: Activity, Media, Notify, Tenant. Mancante: Job.
- Naming audit docs: il canonico resta `module-bmad-audit.story.md`
  (no date); la data va nel frontmatter `created:` e nel contenuto.

## Audit docs trasversale (misurato)

- `Modules/*/docs` + `Themes/*/docs` `.md` (escluse cartelle
  archive/archived/legacy/raw/vendor): 15.358 file.
- Senza front matter (`---`): ~2.167 (stima per assenza di `---`;
  verifica puntuale da fare). Top: User 1051, UI 477, Activity 234,
  Xot 89.
- Nome file con data ISO `YYYY-MM-DD`: 218 file. Top: Notify 43,
  User 28, UI 13, Media 12, Rating 11.
- File `.md` totali repo: ~16.5k (include non-docs).

## Lesson

Con swarm multi-agente attivo, la baseline PHPStan invecchia in
minuti: misurare, mappare le lane attive (mtime < 15min), e
concentrarsi solo sui moduli senza lane — che in questa finestra
erano gia' tutti a 0. Le run intermedie possono mostrare errori
già fixati: verificare sempre il working tree corrente prima di
editare.
