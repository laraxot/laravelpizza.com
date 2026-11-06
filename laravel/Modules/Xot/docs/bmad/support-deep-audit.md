---
title: "Deep audit: no app/Support"
type: bmad-audit
module: Xot
status: active
created: 2026-10-22
updated: 2026-10-22
tags: [bmad, support, queueable-actions, audit]
qmd: "deep audit no app Support faux Action Infrastructure Adapters ThemeBag"
related:
  - ./services-to-queueable-actions-architecture.md
  - ./services-to-queueable-actions-filament-blueprint.md
  - ./filament-blueprint.md
  - ./decision-log.md
  - ../plans/support-to-queueable-actions.md
  - ../../../../../docs/second-brain/process/no-app-support-queueable-actions.md
---

# Deep audit: zero `app/Support` (2026-10-22)

## Misura disco

| Gate | Risultato |
|------|-----------|
| `find …/app/Support` (Modules+Themes, no packages) | **0** |
| Nested `app/*/Support` | **0** |
| `namespace|use …\Support\` in produzione PHP | **0** |
| `NoServicesTest` (Services+Support) | PASS |

## Cosa non e' Support (ma sembrava)

| Artefatto | Verdetto |
|-----------|----------|
| `tests/**/Support` | OK: fixture test |
| `packages/spatie/*/Support` | OK: vendor |
| `SupportsCommentNotifications`, `SupportedLocale` | OK: nomi dominio/enum |
| Blog `Theme*Support` | **rinominato** → `Theme*Bag` (Composition/Data) |
| Geo `GeoDataValidationRules` in Actions | **spostato** → `Infrastructure/Validation` |
| AI `AiActionHandlerRegistry` | **Adapters/** (non Action) |
| Geo API/cache const | **Infrastructure/Config** |
| User `ShieldUtilsAction` | Debito: wrapper statico ex Utils: spezzare |

## Filament blueprint

UI Filament non reintroduce Support: solo Actions tipizzate o props.
Registry/config non si montano come Resource. Canon:
[services-to-queueable-actions-filament-blueprint](./services-to-queueable-actions-filament-blueprint.md).

## Boy scout

1. Prima di creare helper: Action? Adapter? Infrastructure?
2. Mai cartella/namespace `Support` sotto `app/`
3. Mai Action con solo const / `execute()` che restituisce const
4. Aggiornare docs owner nello stesso turn
