---
title: "PHPStan Modules zero — handoff nuova chat"
status: blocked-sync-notify
qmd: "phpstan modules zero handoff standing swarm bmad sync markers"
---

# Handoff — PHPStan Modules zero (incolla in nuova chat)

## 1. Obiettivo principale

Tenere a zero `cd laravel && ./vendor/bin/phpstan analyse Modules` (level max),
causa radice/scopo, swarm BMAD + Hindsight + ECC + ponytail, senza conferma.

## 2. Contesto e vincoli

- Base: `base_laravelpizza_fila5`; moduli = repo `laraxot/module_*_fila5`.
- `bashscripts` → `../base_ptvx_fila5/bashscripts/`.
- Vietato: `@phpstan-ignore*`, baseline, edit neon, `mixed` ultima spiaggia, `require …/Xot/routes/empty.php`.
- **Sync `merge_remote_repo_2.sh` su pizza**: controllare `/proc/<pid>/cwd` (non solo pgrep).
  Non riparare il pacchetto sotto cwd sync — riscrive i marker.
- md kebab, no date nel nome; docs solo in `docs/` esistenti; forward-only git.

## 3. Decisioni e risultati

- Prima del nuovo wave sync: gate **0** (dump-autoload + clear-cache).
- Sync mid-session ha rimesso marker: bootstrap Larastan `unexpected <<`.
- Riparato e pushato:
  - **Cms** `routes/api.php` vuoto locale; `head`/`foot` blade + docs layout (`2b64656e`…`f9c81648`).
  - **Media** `routes/{api,web}.php` senza `empty.php` (ADR).
  - **Lang** `RouteServiceProvider` marker vuoto rimosso (verificare se sync lo ha riscritto).
- **Blocco attuale**: sync cwd = `Modules/Notify` (+ Job) → decine di PHP Notify con `<<<<<<<`; Filament discover Clusters fallisce.
- Invarianti: `HasCommonScopes` mai su `XotBaseModel`; `CoordinatePickerHelpers` + `use` FQCN; dump-autoload dopo churn.

## 4. Dati / punti fermi

```bash
# stato sync
for p in $(pgrep -f merge_remote_repo_2.sh); do echo $p $(readlink /proc/$p/cwd); done
# marker rotte / app
rg -n "^<<<<<<<" laravel/Modules --glob "**/routes/*.php"
rg -l "^<<<<<<<" laravel/Modules --glob "**/*.php" --glob "!**/docs/**" --glob "!**/tests/**"
cd laravel && composer dump-autoload -o && ./vendor/bin/phpstan clear-result-cache && ./vendor/bin/phpstan analyse Modules
```

- ADR: `Modules/Xot/docs/adr/no-shared-empty-route-file.md`
- Story: [phpstan-modules-zero-swarm-standing.story.md](./phpstan-modules-zero-swarm-standing.story.md)
- Prompt: `bashscripts/docs/prompts/37-phpstan.md`
- Hindsight: `kp-b6695b8fc43a4979bd32799eb6db4b18`

## 5. Prossimo passo

1. **Aspettare** che sync lasci `Modules/Notify` (cwd → Seo/Tenant/UI/User/Xot/tema).
2. Riparare TUTTI i marker Notify (Filament page `SendFirebasePushNotificationPage` prima — blocca discover), poi `rg` su Modules.
3. Cold `analyse Modules` → 0; commit/push repo Notify (+ altri toccati).
4. Se sync ancora su un modulo: misurare/riparare solo pacchetti **già visitati e stabili**.

## Related

- [standing story](./phpstan-modules-zero-swarm-standing.story.md)
- [ADR empty routes](../../adr/no-shared-empty-route-file.md)
