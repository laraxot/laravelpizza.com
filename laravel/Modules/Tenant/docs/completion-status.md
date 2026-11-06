---
title: "Tenant: cosa manca per completare"
type: status
module: Tenant
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# Tenant: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 53 |
| Errori PHPStan livello 10 | 0 |
| Blade (troncate in testa) | 4 (0) |
| File di test (`*Test.php`) | 42 |
| TODO/FIXME nel codice | 0 |
| Traduzioni it / en (solo in it) | 6 / 2 (4) |
| Story/epic BMAD (aperte) | 28 (19) |

## Problemi noti e prossimi passi

Nessun problema bloccante emerso dai controlli del 2026-10-28 oltre agli indicatori sopra e alle story aperte.

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| in-progress | [Tenant: boundary Sushi PHPStan](docs/stories/7.1.phpstan-sushi-boundaries.story.md) |
| review | [config/local untracciata applicando il .gitignore ai file tracciati](docs/bmad/stories/tenant-config-untracked-by-gitignore.story.md) |
| review | [Tenant: contratti PHPStan dei test harness](docs/stories/7.2.phpstan-test-harness-contracts.story.md) |
| review | [Tenant: unique/exists sui modelli Sushi (connessione per nome)](docs/stories/7.4.sushi-connection-by-name.story.md) |
| ready-for-dev | [[STORY] Tenant: parita' di TenantService e Services/Config con le Action successore](docs/stories/services-parity-audit-tenant.story.md) |
| ready-for-dev | [Tenant: Unit Tests for claude-audit 100/100](docs/stories/tenant-unit-tests-claude-audit.story.md) |
| todo | [Profilo di test per le connessioni tenant](docs/stories/tenant-test-connection-profile.story.md) |
| backlog | [Continuazione domani](docs/bmad/stories/continuazione-domani.story.md) |
| backlog | [Multi-tenant scope isolation (tenant_id in queries)](docs/stories/3.5.multi-tenant-scope-isolation.story.md) |
| backlog | ['Row-Level Security: verify RLS policies active'](docs/stories/3.8.verify-rls-policies.story.md) |
| backlog | ['Monitoring setup: Vercel logs + alerting on errors'](docs/stories/5.8.monitoring-alerting-setup.story.md) |
| backlog | ['Filament setup wizard: DB init + seed'](docs/stories/6.1.setup-wizard-db-init-seed.story.md) |
| backlog | [Isolamento tenant dei contenuti editoriali](docs/stories/inbound-tenant-content-isolation.story.md) |
| draft | [Riorganizzazione docs core Tenant](docs/bmad/stories/docs-reorg-core.story.md) |
| active | [8.2-phpstan-l10-tenant-sushi-fixes.story.md](docs/bmad/stories/8.2-phpstan-l10-tenant-sushi-fixes.story.md) |
| blocked | [Tenant: PHPStan TenantStatementCoverageTest loadExistingData](docs/bmad/stories/tenant-phpstan-statement-coverage-test.story.md) |
| active | [7.5-create-json-max-oneliner.story.md](docs/stories/7.5-create-json-max-oneliner.story.md) |
| senza-status | [01.Tenant phpstan fix.story](docs/stories/01.Tenant-phpstan-fix.story.md) |
| senza-status | [sushitojson-test-fixtures.story.md](docs/stories/sushitojson-test-fixtures.story.md) |

2 story non hanno `status:` nel frontmatter: vanno classificate (done / backlog / superseded).
