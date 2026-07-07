---
title: "Piattaforma Fixcity — roadmap completamento (SSoT)"
type: overview
tags: [xot, platform, roadmap, phpstan, pest, completion, gate]
created: 2026-06-13
updated: 2026-06-17
qmd: "completare progetto Fixcity roadmap PHPStan Pest moduli temi gate ingresso chef"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/353"
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - ../../../../../docs/stories/STORY-367-platform-completion-programme.md
  - ../../../Fixcity/docs/wiki/overviews/completion-roadmap.md
  - ../../../../Themes/Sixteen/docs/wiki/overviews/completion-roadmap.md
  - ../concepts/phpstan-pest-bridge-discipline.md
  - ../PHPSTAN-BEST-PRACTICES.md
  - ../../../../../docs/wiki/PHPSTAN-INDEX.md
---

# Piattaforma Fixcity — roadmap completamento

Documento **hub** dopo gate ingresso chef (2026-06-13). Ogni modulo/tema ha dettaglio locale; qui solo stato trasversale e priorità.

## Gate qualità (obbligatorio prima di feature)

| Check | Comando | Stato 2026-06-13 |
|-------|---------|------------------|
| PHPStan 16 moduli | `cd laravel && php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules` | ✅ **[OK] No errors** (6344 file, 2026-06-17) |
| `phpstan.neon` | Solo utente | 🔒 intoccabile |
| Pest moduli toccati | `cd laravel && ./vendor/bin/pest --filter=…` | 🔄 dopo ogni batch |
| Naming test login | 15 file scope-distinct, zero lowercase duplicati | ✅ |
| Test PHPUnit class-based | Vietato nei moduli | ✅ |
| Cartella `tests/` lowercase | Namespace `Modules\*\Tests` PascalCase | 🔄 [#370](https://github.com/laraxot/base_fixcity_fila5/issues/370) |

## Migliorie sessione gate (codice + test)

| Owner | Cosa | Pattern |
|-------|------|---------|
| Activity | 7 file `tests/Unit/Actions/*` | `expect()` → `Assert::assert*()`; `createOne()`; eccezioni con try/catch |
| Fixcity | `tests/helpers/PestHelper.php` | PHPDoc `class-string`; helper non usati ancora in produzione |
| Xot | `FileActionsTest`, `GetClassNameByPathActionTest` | No `@var $this` se closure non usa `$this`; no `assertIsString` su `tempnam()` |
| Fixcity (prior) | 88 errori test | Helper `ticket()`, `authUser()` — [doc](../../../Fixcity/docs/wiki/concepts/phpstan-pest-testcase-helpers.md) |
| Notify (prior) | Trait doubles | [phpstan-pest-test-doubles](../../../Notify/docs/wiki/concepts/phpstan-pest-test-doubles.md) |

**Regola religione test PHPStan:** Pest resta runner; assertion pubbliche `PHPUnit\Framework\Assert` quando `expect()` genera `method.internalClass`. Canon: [phpstan-pest-bridge-discipline](../concepts/phpstan-pest-bridge-discipline.md).

## Stato moduli (16)

| Modulo | PHPStan | Prossimo passo business | Doc locale |
|--------|---------|-------------------------|------------|
| **Xot** | ✅ | Bridge Pest, TestCase hierarchy, phpunit centrale | [xot-module](xot-module.md) |
| **Fixcity** | ✅ | Segnalazioni FO, wizard, Services→Actions | [completion-roadmap](../../../Fixcity/docs/wiki/overviews/completion-roadmap.md) |
| **Activity** | ✅ | Coverage Pest, audit test duplicati legacy | [completion-status](../../../Activity/docs/wiki/overviews/completion-status.md) |
| **AI** | ✅ | Allineare worktree `SentimentActionTest` | [ai-module](../../../AI/docs/wiki/overviews/ai-module.md) |
| **User** | ✅ | Profilo UUID, auth FO | [user-module](../../../User/docs/wiki/overviews/user-module.md) |
| **Geo** | ✅ | Popup mappe, GeoJSON pubblico | [geo-module](../../../Geo/docs/wiki/overviews/geo-module.md) |
| **Cms** | ✅ | `<x-page>` data bag, blocchi segnalazioni | [cms-module](../../../Cms/docs/wiki/overviews/cms-module.md) |
| **UI** | ✅ | Componenti Filament + test Sixteen | [ui-module](../../../UI/docs/wiki/overviews/ui-module.md) |
| **Notify** | ✅ | Contratto `notifications` owner | [test doubles](../../../Notify/docs/wiki/concepts/phpstan-pest-test-doubles.md) |
| **Tenant** | ✅ | Multi-tenancy notifiche | [tenant-module](../../../Tenant/docs/wiki/overviews/tenant-module.md) |
| **Comment** | ✅ | FO ticket + native comments | [testing](../../../Comment/docs/wiki/concepts/testing.md) |
| **Rating** | ✅ | Rating cittadino ticket | [phpstan-compliance](../../../Rating/docs/wiki/concepts/phpstan-compliance.md) |
| **Blog** | ✅ | Contenuti editoriali | [blog-module](../../../Blog/docs/wiki/overviews/blog-module.md) |
| **Media** | ✅ | Upload allegati ticket | [media-module](../../../Media/docs/wiki/overviews/media-module.md) |
| **Lang** | ✅ | i18n FO senza `route()` | [lang-module](../../../Lang/docs/wiki/overviews/lang-module.md) |
| **Seo** | ✅ | Meta segnalazioni pubbliche | [seo-module](../../../Seo/docs/wiki/overviews/seo-module.md) |
| **Gdpr** | ✅ | Consensi profilo | [phpstan-compliance](../../../Gdpr/docs/wiki/concepts/phpstan-compliance.md) |
| **Job** | ✅ | Code async Actions | [phpstan-compliance](../../../Job/docs/wiki/concepts/phpstan-compliance.md) |

## Stato temi (4)

| Tema | Ruolo | Prossimo passo | Doc |
|------|-------|----------------|-----|
| **Sixteen** | FO owner Fixcity | Design Comuni parity, Folio shell | [completion-roadmap](../../../../Themes/Sixteen/docs/wiki/overviews/completion-roadmap.md) |
| **Barthelemy** | Alternativo / admin skin | Allineare shared components | [completion-roadmap](../../../../Themes/Barthelemy/docs/wiki/overviews/completion-roadmap.md) |
| **TwentyOne** | Visual testing | Playwright baseline | [completion-roadmap](../../../../Themes/TwentyOne/docs/wiki/overviews/completion-roadmap.md) |
| **Meetup** | Eventi (satellite) | Copertura test minima | [completion-roadmap](../../../../Themes/Meetup/docs/wiki/concepts/meetup-completion-roadmap.md) |

## Milestone progetto (ordine)

### M1 — Qualità statica ✅ (2026-06-13)
- PHPStan zero su `Modules/`
- Pattern Pest+Assert documentati per modulo

### M2 — Test runtime 🔄
- Pest green su tutti i moduli (`phpunit.xml` centrale [#345](https://github.com/laraxot/base_fixcity_fila5/issues/345))
- Coverage batch [#372](https://github.com/laraxot/base_fixcity_fila5/issues/372)
- `APP_ENV=testing` parity: `sync-env-testing.sh`

### M3 — Core business Fixcity
- Lista + dettaglio + wizard segnalazione su Sixteen
- Mappe GeoJSON + popup canonico
- Seeders demo [#368](https://github.com/laraxot/base_fixcity_fila5/issues/368)
- Migrazione `Services/` → `Actions/` in Fixcity

### M4 — Architettura Laraxot
- Provider solo in `module.json` + `composer.json`
- 1 modello = 1 `create_*` migrazione
- No Controllers; Folio + Actions
- Parità artefatti: `audit-module-artifact-parity.sh`

### M5 — Produzione
- CI GitHub Actions (phpstan + pest + pint)
- Docker compose documentato
- Playwright FO critico

### M6 — Prodotto PA (scopo + target) 🔄
- SSoT scopo/target: [fixcity-scopo-e-target.md](../../../../../docs/wiki/concepts/fixcity-scopo-e-target.md)
- Epic BMAD: [STORY-367](../../../../../docs/stories/STORY-367-platform-completion-programme.md) child **389–395**
- Design Comuni parity ([#416](https://github.com/laraxot/base_fixcity_fila5/issues/416))
- Workflow ticket + Activity ([#420](https://github.com/laraxot/base_fixcity_fila5/issues/420))
- Filament BO ([#422](https://github.com/laraxot/base_fixcity_fila5/issues/422))
- WCAG + i18n ([#424](https://github.com/laraxot/base_fixcity_fila5/issues/424))
- Production readiness ([#426](https://github.com/laraxot/base_fixcity_fila5/issues/426))
- Timeline cittadino ([#400](https://github.com/laraxot/base_fixcity_fila5/issues/400))

## Workflow agente (gate chef)

1. PHPStan zero → 2. `docs/chat/INDEX.md` → 3. QMD search → 4. GitHub issue/discussion owner → 5. STORY → 6. codice.

Chat sessione: [docs/chat/2026-06-13-phpstan-modules-second-brain-docs.md](../../../../../docs/chat/2026-06-13-phpstan-modules-second-brain-docs.md).

## Definition of Done piattaforma

- [x] PHPStan `Modules` zero errori codice
- [ ] Pest suite moduli verde in CI
- [ ] Fixcity FO segnalazioni end-to-end su Sixteen
- [ ] Zero nuovi `app/Services/` / `Modules/*/app/Services/`
- [ ] Wiki moduli/temi con link GitHub in frontmatter
- [ ] Issue [#372](https://github.com/laraxot/base_fixcity_fila5/issues/372) chiusa con STORY-350 completa
