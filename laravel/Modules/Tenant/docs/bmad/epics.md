---
title: "Epics BMAD — Tenant"
type: epics
status: active
tags: [docs, tenant, bmad]
created: 2026-10-06
updated: 2026-11-16
module: Tenant
tags: [docs, tenant, bmad]
created: 2026-10-06
qmd: "epics Tenant TrustHosts tenant admin perimetro DatabaseConfig encrypted pulizia sushi docs collisioni maiuscole"
---

# Epics — Tenant

Origine: [audits/tenant-audit.md](./audits/tenant-audit.md). Epic storici: [epics/tenant-config-resolution.md](./epics/tenant-config-resolution.md), [epics/module-roadmap.md](./epics/module-roadmap.md). Story di coordinamento: [module-bmad-audit.story.md](./stories/module-bmad-audit.story.md).

Ordine di valore: prima l'isolamento fra enti (A), poi chi amministra (B), poi i segreti (C).

## Epic A — Host fidato (TEN-P1-01)

**Perché:** il tenant deriva dall'host; un `Host:` forgiato su un vhost catch-all seleziona la config di un altro ente.

- Task: attivare `TrustHosts` (pattern dai domini in `config/<tenant>/`) oppure documentare e verificare il vhost/`server_name` esplicito.
- AC: un host non elencato non seleziona un tenant diverso dal default; test su `GetTenantNameAction` con `Host` forgiato.
- File: [GetTenantNameAction.php](../../app/Actions/GetTenantNameAction.php), `laravel/app/Http/Kernel.php`, `laravel/bootstrap/app.php`.
- Decisione aperta: fallire (HTTP 400) o ripiegare sul default — vedi [purpose.md](./purpose.md) §3.

## Epic B — Perimetro `tenant::admin` (TEN-P1-02)

- Task: test Pest che fissa cosa può fare `tenant::admin` (incluso `delete`/`forceDelete` su `Domain`); se non voluto, limitare `before()` alle ability non distruttive.
- AC: test verde; decisione registrata in [decision-log.md](./decision-log.md).
- File: [TenantBasePolicy.php](../../app/Models/Policies/TenantBasePolicy.php), [DomainPolicy.php](../../app/Models/Policies/DomainPolicy.php).

## Epic C — Credenziali `DatabaseConfig` (TEN-P1-03)

- Task: cast `encrypted` e `$hidden` su `password`; migrazione **additiva** (nuova colonna o cifratura dei valori esistenti con comando idempotente) — mai wipe, mai `--force`.
- AC: `toArray()` non contiene la password; round-trip cifrato testato su sqlite.
- File: [DatabaseConfig.php](../../app/Models/DatabaseConfig.php), [migration](../../database/migrations/2026_07_24_000002_create_database_configs_table.php).

## Epic D — Pulizia (TEN-P2-01…04, 07, 08)

- Fondere `SushiToJsons` in `SushiToJson` (o rimuovere `BaseModelJsons` se non usato); `file_exists` prima di `unlink`.
- Spostare `TestSushiModel`/`TestCommand` sotto `tests/`; togliere i 3 `@phpstan-ignore trait.unused`.
- Decidere dove nasce la tabella `tenants` (`Tenant` e factory esistono, nessuna migration nel repo).
- Accorpare i 10 test "coverage" nei test di regola.

## Epic E — Docs (TEN-P2-05, 06)

- Risolvere le 18 collisioni di maiuscole (tenere il nome minuscolo, `README.md` escluso) e `module-bmad-audit-20260928.story.md`.
- Sostituire le citazioni a `TenantService::` con `GetTenantFilePathAction` e riallineare [brainstorming.md](./brainstorming.md).
- `qmd update` a fine epic.
