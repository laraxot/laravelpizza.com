---
title: "PHPStan Modules zero — handoff nuova chat"
status: verified-zero-fragile-sync
updated: 2026-11-24
qmd: "phpstan modules zero handoff standing swarm bmad sync markers"
---

# Handoff — PHPStan Modules zero (incolla in nuova chat)

## 1. Obiettivo principale

Tenere a **0** `cd laravel && ./vendor/bin/phpstan analyse Modules` (level max),
causa radice/scopo (non sintomo), swarm BMAD + Hindsight + ECC + ponytail,
senza attendere conferma. Migliorare docs moduli/temi e `bashscripts/docs/prompts`.

## 2. Contesto e vincoli

- Base: `base_laravelpizza_fila5`; moduli = repo `laraxot/module_*_fila5`.
- `bashscripts` → symlink `../base_ptvx_fila5/bashscripts/`.
- Vietato: `@phpstan-ignore*`, baseline, edit `phpstan.neon`, `mixed` ultima spiaggia,
  `require …/Xot/routes/empty.php` (ADR `no-shared-empty-route-file`).
- **Sync `merge_remote_repo_2.sh`**: controllare `/proc/<pid>/cwd` (non solo pgrep).
  Non riparare il pacchetto sotto cwd sync — riscrive i marker.
- Fratello pulito spesso: `base_ptvx_fila5/laravel/Modules/<M>/` (copiare se disk clean).
- md kebab, no date nel nome; `@see Modules/<M>/docs/...` su classi/metodi toccati.
- Forward-only git; commit/push sul **repo owner** del modulo quando verde.

## 3. Decisioni e risultati

- **2026-11-24 ~19:12**: cold `analyse Modules` → **`[OK] No errors`** (dopo clear-cache).
- Bootstrap era FATAL su `RelationX.php` marker `<<`; `laraxot/dev` a volte ha marker
  sporchi → ripristino da **ptvx** sibling clean.
- Ripristinati da ptvx (marker wave): Xot app 8, UI routes+Actions, User app **87** +
  migrations/lang parse.
- `HasCommonScopes`: **mai** su `XotBaseModel`; consumer `NotificationTemplate` + `Module`;
  PHPDoc `Builder<$this>` (niente `@template TModel` — evitava `missingType.generics`).
- `Modules/Xot/routes/empty.php` **git rm** (era `D` in WT; PHPStan `phpstan.path` se
  riappare in index). ADR: stub locale per modulo, non file condiviso.
- Notify `.git` slim: **14MB / 1 commit** shallow (`c642ea4`); bak
  `.git.polluted.bak.202611241827`; remoto ancora polluto ~431MB.
- bashscripts md wave: ~12890 → **12450**; lane A/B/C/D done (00-INDEX, links, path refs,
  Notify slim). Commit bashscripts ancora staged/pending se non fatto.

## 4. Dati / punti fermi

```bash
# sync
for p in $(pgrep -f merge_remote_repo_2); do echo $p $(readlink -f /proc/$p/cwd); done
# marker produzione
rg -l '^<<<<<<<' laravel/Modules --glob '**/app/**/*.php' --glob '**/routes/**/*.php' \
  --glob '**/lang/**/*.php' --glob '**/database/migrations/**/*.php'
# restore da ptvx se clean
# cp base_ptvx_fila5/laravel/Modules/X/... → pizza
cd laravel && composer dump-autoload -o && ./vendor/bin/phpstan clear-result-cache \
  && ./vendor/bin/phpstan analyse Modules --memory-limit=2G
```

- ADR empty routes: `Modules/Xot/docs/adr/no-shared-empty-route-file.md`
- Event published: `Modules/Meetup/docs/contracts/event-published-scope.md`
- Standing: [phpstan-modules-zero-swarm-standing.story.md](./phpstan-modules-zero-swarm-standing.story.md)
- Prompt: `bashscripts/docs/prompts/37-phpstan.md` (+ `@see` in `18-struttura-file-php.md`)
- Git slim Notify: `Modules/Xot/docs/bmad/stories/module-theme-git-slim.story.md`
- Hindsight: `kp-b6695b8fc43a4979bd32799eb6db4b18`, `kp-7e6cbd5e8d3e4ae4956fcb177aab81a0`

## 5. Prossimo passo

1. Sync ancora attivo (ultimo check cwd poteva essere **User** o **UI**): se rimette
   marker, **non** riparare sotto cwd; dopo uscita, `rg` + restore ptvx + cold analyse.
2. Commit/push moduli toccati (Xot HasCommonScopes + empty.php rm; User/UI restore) nei
   **repo owner**, non solo monorepo.
3. Opzionale: commit bashscripts staged (43× `00-INDEX` + docs); rewrite path docs su
   copie private (fixcity/… 207 ref) quando sync porta layout nuovo.
4. Se gate rosso: prima `clear-result-cache` + `dump-autoload -o`; poi marker; poi tipi.

## Related

- [standing story](./phpstan-modules-zero-swarm-standing.story.md)
- [ADR empty routes](../../adr/no-shared-empty-route-file.md)
- [bashscripts layout story](../../../../../../bashscripts/docs/stories/bashscripts-docs-layout-by-purpose.story.md)
