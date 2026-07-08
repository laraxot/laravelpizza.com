---
title: Merge Conflict Task List
type: taskboard
updated: 2026-04-21
rule: merge-conflict-marker-resolution
---

# Merge Conflict Task List

Elenco file con marker `<<<<<<<` / `>>>>>>> .merge_file_*` da risolvere.
Ogni agente prende un file, lo risolve semanticamente (non meccanicamente), e spunta la voce.

**Regola**: risoluzione distribuita multi-agente — un file per turno, spuntare dopo risoluzione.

## Risolti ✅

- [x] `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` — rimosso button duplicato align-self-start, rimosso JS header-colors duplicato, rimosso `</style>` duplicato *(2026-04-21)*
- [x] `laravel/Modules/Cms/app/Filament/Clusters/Appearance/Pages/Breadcrumb.php` — rimossa rideclarazione `public array $data` *(2026-04-21)*
- [x] `laravel/Modules/Cms/app/Filament/Clusters/Appearance/Pages/Footer.php` — rimossa rideclarazione `public array $data` *(2026-04-21)*
- [x] `laravel/Modules/Cms/app/Filament/Clusters/Appearance/Pages/Headernav.php` — rimossa rideclarazione `public array $data` *(2026-04-21)*

## Da risolvere

### docs root
- [ ] `docs/raw/README.md`
- [ ] `docs/wiki/concepts/no-docs-archive-rule.md`
- [ ] `docs/wiki/index.md`
- [ ] `docs/wiki/log.md`

### Modules/Blog
- [ ] `laravel/Modules/Blog/docs/wiki/README.md`

### Modules/Cms
- [ ] `laravel/Modules/Cms/docs/errors/git-conflicts-themes-resolution.md`
- [ ] `laravel/Modules/Cms/docs/roadmap.md`
- [ ] `laravel/Modules/Cms/docs/roadmap/legacy/legacy-roadmap-3.md`
- [ ] `laravel/Modules/Cms/docs/roadmap/legacy/legacy-roadmap-x.md`
- [ ] `laravel/Modules/Cms/docs/wiki/README.md`
- [ ] `laravel/Modules/Cms/docs/wiki/_archive/filament-4x-compatibility.md`

### Modules/Comment
- [ ] `laravel/Modules/Comment/docs/wiki/README.md`

### Modules/Fixcity
- [ ] `laravel/Modules/Fixcity/docs/wiki/README.md`
- [ ] `laravel/Modules/Fixcity/docs/wiki/index.md`
- [ ] `laravel/Modules/Fixcity/docs/wiki/log.md`

### Modules/Gdpr
- [ ] `laravel/Modules/Gdpr/docs/wiki/README.md`

### Modules/Geo
- [ ] `laravel/Modules/Geo/docs/wiki/AGENTS.md`
- [ ] `laravel/Modules/Geo/docs/wiki/README.md`
- [ ] `laravel/Modules/Geo/docs/wiki/log.md`

### Modules/Job
- [ ] `laravel/Modules/Job/docs/wiki/README.md`

### Modules/Lang
- [ ] `laravel/Modules/Lang/docs/wiki/README.md`

### Modules/Media
- [ ] `laravel/Modules/Media/docs/wiki/README.md`

### Modules/Notify
- [ ] `laravel/Modules/Notify/.planning/debug/knowledge-base.md`
- [ ] `laravel/Modules/Notify/.planning/debug/resolved/sqlite-model-contract-fix.md`
- [ ] `laravel/Modules/Notify/docs/wiki/index.md`

### Modules/Seo
- [ ] `laravel/Modules/Seo/docs/wiki/README.md`

### Modules/Tenant
- [ ] `laravel/Modules/Tenant/docs/wiki/README.md`

### Modules/User
- [ ] `laravel/Modules/User/docs/README.md`
- [ ] `laravel/Modules/User/docs/tasks/fixoc-merge-kers.md`
- [ ] `laravel/Modules/User/docs/wiki/README.md`

### Modules/docs (shared)
- [ ] `laravel/Modules/docs/docs/wiki/README.md`
- [ ] `laravel/Modules/docs/docs/wiki/index.md`
- [ ] `laravel/Modules/docs/docs/wiki/log.md`

### Themes/Sixteen
- [ ] `laravel/Themes/Sixteen/docs/00-INDEX.md`
- [ ] `laravel/Themes/Sixteen/docs/css-js-parity.md`
- [ ] `laravel/Themes/Sixteen/docs/wiki/index.md`
- [ ] `laravel/Themes/Sixteen/docs/wiki/log.md`

### Themes/docs (shared)
- [ ] `laravel/Themes/docs/docs/wiki/README.md`
- [ ] `laravel/Themes/docs/docs/wiki/index.md`
- [ ] `laravel/Themes/docs/docs/wiki/log.md`

## Protocollo agente

1. Scegli un file `- [ ]` non ancora assegnato
2. Leggi il file e ragiona semanticamente (non prendere meccanicamente una versione)
3. Risolvi: preserva business logic, elimina duplicazioni, segui regole DRY+KISS
4. Spunta la voce con `- [x]` e data
5. Aggiorna `wiki/log.md` del modulo/tema con entry

## Riferimento regola

`bashscripts/ai/.claude/rules/merge-conflict-marker-resolution.md`