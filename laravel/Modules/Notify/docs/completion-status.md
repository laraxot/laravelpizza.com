---
title: "Notify: cosa manca per completare"
type: status
module: Notify
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# Notify: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 239 |
| Errori PHPStan livello 10 | 0 |
| Blade (troncate in testa) | 85 (0) |
| File di test (`*Test.php`) | 132 |
| TODO/FIXME nel codice | 6 |
| Traduzioni it / en (solo in it) | 82 / 38 (44) |
| Story/epic BMAD (aperte) | 46 (31) |

## Problemi noti e prossimi passi

| Priorita' | Problema | Dove si lavora |
|---|---|---|
| SICUREZZA | SettingPage (EnvWidget su `.env` con segreti) senza `canAccess`: la vede chiunque acceda al pannello. | `stories/setting-page-access-and-name.story.md` |

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| in-progress | [Notify: resolve git conflict markers in the template version model test](docs/stories/resolve-conflict-markers-notify.story.md) |
| review | [Notify: marker in SendNetfunSMSAction + lang](docs/bmad/stories/netfun-conflict-markers.story.md) |
| review | [Riduzione uso di mixed dove il tipo reale e' conoscibile](docs/stories/4.28.mixed-type-reduction.story.md) |
| review | [app/Services -> app/Actions (QueueableAction), modulo Notify](docs/stories/4.29.notify-services-to-actions.story.md) |
| ready-for-dev | [Notify: baseline BMAD e analisi completa](docs/bmad/stories/module-bmad-audit.story.md) |
| ready-for-dev | [Consolidate Email module into Notify as channel provider](docs/stories/01.consolidate-email-into-notify.story.md) |
| ready-for-dev | [Hook database-notifications FQCN](docs/stories/12.1.notify-notifications-fqcn.story.md) |
| ready-for-dev | [Story 4.23: PHPStan regression remediation: Notify](docs/stories/4.23.phpstan-regression-remediation.story.md) |
| ready-for-dev | [Story 4.25: Git conflict marker remediation: Notify (unrelated-history merge regression)](docs/stories/4.25.git-conflict-marker-remediation.story.md) |
| ready-for-dev | [Story 4.32: swarm PHPStan Notify: internal-error ambiente vs fix reali](docs/stories/4.32.notify-phpstan-swarm-internal-errors.story.md) |
| ready-for-dev | [Modules/Notify: la suite Pest non riesce a interrogare il database in modo affidabile: la](docs/stories/notify-pest-suite-database-resolver-broken.story.md) |
| ready-for-dev | [Notify: Unit Tests for claude-audit 100/100](docs/stories/notify-unit-tests-claude-audit.story.md) |
| ready-for-dev | [[STORY] Notify: parita' di SmsService, NotificationManager e Mail engine con le Action suc](docs/stories/services-parity-audit-notify.story.md) |
| ready-for-dev | [SettingPage di Notify: accesso libero ai segreti e nome](docs/stories/setting-page-access-and-name.story.md) |
| open | [Decidere il destino di Notify/.github/skills, 1846 file tracciati](docs/stories/notify-tracked-github-skills-hygiene.story.md) |
| backlog | [Continuazione domani](docs/bmad/stories/continuazione-domani.story.md) |
| backlog | [Email Delivery Tracking (Bounce Log, Retry Logic)](docs/stories/1.12.email-delivery-tracking.story.md) |
| backlog | [Send Scheda Email](docs/stories/1.2.send-scheda-email.story.md) |
| backlog | [Export Scheda to PDF](docs/stories/1.7.export-scheda-pdf.story.md) |
| backlog | [Notify docs/ frontmatter batch enrichment (pattern riusato da Xot)](docs/stories/docs-frontmatter-batch-enrichment.story.md) |
| draft | [Notify: epic 5.251: canali e provider di notifica](docs/bmad/epics/notification-channels.epic.md) |
| draft | [cleanup notify 2026 09 22.story](docs/bmad/stories/cleanup-notify.story.md) |
| draft | [Riorganizzazione docs core Notify](docs/bmad/stories/docs-reorg-core.story.md) |
| active | [Notify Module: Document](docs/bmad/stories/consolidation-orphan-docs.story.md) |
| blocked-on-owner | [Story 4.30: module_notify_fila5 remote git object corruption: push blocked](docs/stories/4.30.module-remote-git-object-corruption.story.md) |
| deferred | [Nurture editoriale post-evento (deferred)](docs/stories/inbound-nurture-deferred.story.md) |
| senza-status | [9.1.psr4 duplicate dedup.story](docs/stories/9.1.psr4-duplicate-dedup.story.md) |
| senza-status | [Notify Module: Table Audit and $model Property](docs/stories/continuation.story.md) |
| senza-status | [netfun sms error log false positive.story](docs/stories/netfun-sms-error-log-false-positive.story.md) |
| senza-status | [no model extends eloquent directly.story](docs/stories/no-model-extends-eloquent-directly.story.md) |
| senza-status | [xotbaseresourcetable model audit notify batch.story](docs/stories/xotbaseresourcetable-model-audit-notify-batch.story.md) |

5 story non hanno `status:` nel frontmatter: vanno classificate (done / backlog / superseded).
