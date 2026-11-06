---
title: Wave globale Services verso Spatie Queueable Actions
type: story
module: Xot
status: done
priority: high
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, services, queueable-action, planning, filament-blueprint]
qmd: "services to actions global wave tenant geo xot notify zombies trend translators ratchet delete zero dirs"
related:
  - ../bmad/brainstorming-services-to-actions-wave.md
  - ../bmad/planning-services-to-actions-zero-folders.md
  - ../bmad/filament-blueprint.md
  - ../bmad/services-to-queueable-actions-architecture.md
  - ../bmad/services-to-queueable-actions-filament-blueprint.md
  - ../bmad/services-to-queueable-actions-objective.md
  - ../bmad/services-to-queueable-actions-census.md
  - ../bmad/services-to-queueable-actions-brainstorming.md
  - ./services-to-actions-xot-small.story.md
  - ./phpstan-modules-zero-wave3.story.md
  - ./phpstan-modules-zero-gate.story.md
  - ../../Geo/docs/stories/services-zombie-delete-wave3.story.md
  - ../../Notify/docs/stories/services-to-actions-notify.story.md
  - ../../Notify/docs/stories/phpstan-notificationmanager-service-removed.story.md
  - ../../Tenant/docs/stories/services-to-actions-tenant.story.md
  - ../../../../../bashscripts/docs/prompts/25-services-to-actions.md
  - ../../../../../bashscripts/ai/wiki/rules/no-services-rule.md
---

# Wave globale: Services → Queueable Actions

Fase BMAD: **done** (maintain + boy scout delete-again se merge).
Planning: [planning-services-to-actions-zero-folders.md](../bmad/planning-services-to-actions-zero-folders.md).
Brainstorm: [brainstorming-services-to-actions-wave.md](../bmad/brainstorming-services-to-actions-wave.md).
Architecture: [services-to-queueable-actions-architecture.md](../bmad/services-to-queueable-actions-architecture.md).
Filament: [services-to-queueable-actions-filament-blueprint.md](../bmad/services-to-queueable-actions-filament-blueprint.md).

## Perche'

Regola religione: **nessuna cartella** `Modules/*/app/Services/` deve esistere.
Un caso d'uso = una Action Spatie con `execute()`. I residui tipici sono **copie
riesumate dal merge** di Actions gia' esistenti: convertire a tappeto duplica;
la procedura e' **cerca Action → retarget chiamanti → delete Service → rmdir**.

## Stato misurato (disco vivo, 2026-10-20 sera)

| Cluster | Stato | Prossimo passo |
|---------|-------|----------------|
| Notify / Tenant / Xot / Lang / Media / Job / AI / UI `*Service` applicativi | **GONE** | chiuso |
| Geo cinque `*Service` | **GONE** (0 `use Modules\Geo\Services\`) | delete-again se merge |
| Notify `Services/NotificationManager` | **GONE** | vivo = `Actions\NotificationManager` |
| Xot `ProfileTest` / Translators / Trend sotto Services | **GONE** | policy delete-again |
| Cartelle `app/Services` | **0** | ratchet `NoServicesTest` PASS |
| Actions `Modules/*/app/Actions` | **~770** | n/a |
| `TermsOfService` Livewire | ritirato W0 REUSE | n/a |

## Ordine operativo (se riesumazione)

1. `rg` Action successore + caller produzione (`use Modules\<M>\Services\`).
2. Retarget caller (Facade/composer/test) se servono; **non** creare Action duplicate.
3. DELETE Service + `rmdir` cartella.
4. Confermare `archAllowedServicesDirs()` = `[]`.
5. Gate: `find` dirs/files vuoti + PHPStan perimetro (`--memory-limit=2G` se RAM bassa).

## Filament

[filament-blueprint](../bmad/filament-blueprint.md) +
[services-to-queueable-actions-filament-blueprint](../bmad/services-to-queueable-actions-filament-blueprint.md):
form/page/widget chiamano Actions, mai Service. Cms Appearance/Breadcrumb = canarino Tenant.

## Acceptance

- [x] Zero directory `Modules/*/app/Services` (escl. `tests/`)
- [x] Zero `*Service.php` applicativi sotto `Modules/*/app/Services`
- [x] Zero file residui sotto `app/Services` (corretto 2026-10-20: `laravel/app/Services` aveva 3 classi senza chiamanti e `Themes/Sixteen/src/Services` 3 orfani, rimossi in [DCP-270](./dcp-270-no-services-ratchet-e-residui-app-e-tema.story.md))
- [x] Caller Filament/Data su Actions (Tenant canary = commenti `Was:` + config Actions)
- [x] Ratchet anti-riesumazione: **`Modules/Xot/tests/Unit/Architecture/NoServicesTest.php`** (directory + namespace + `use`; allowlist vuota; prova inversa fatta). Corretto 2026-10-20: il `ModulesArchitectureTest` citato prima non esisteva nel codice ([DCP-270](./dcp-270-no-services-ratchet-e-residui-app-e-tema.story.md))
- [x] PHPStan `analyse Modules` a 0 (remeasure con `--memory-limit=2G` post-SIGKILL)
- [x] Docs/brainstorm/architecture/filament blueprint aggiornati
- [x] Policy delete-again documentata per Translators/Trend/Geo

## Verifica mid-sessione → chiusura sera

Mid-sessione (~12:40): 8 dirs + 5 Geo PHP. Actions gia' dichiaravano «Sostituisce…».
`use Modules\Geo\Services\` = 0. Post-cleanup + sera: dirs=0, PHP=0, import prod=0,
Actions ~770, `NoServicesTest` 3 PASS, PHPStan Modules OK.
Boy scout resta standing order su ogni merge.
