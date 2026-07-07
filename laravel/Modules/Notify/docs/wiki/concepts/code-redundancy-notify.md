---
title: "ridondanza codice e documentazione — modulo Notify"
module: Notify
type: concept
tags: [redundancy, notify, filament, templates]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - ../../../redundancy-audit-2026-05-21.md
  - ../../../../Xot/docs/wiki/concepts/code-redundancy-philosophy.md
  - ../../../../Xot/docs/wiki/redundancy-audit-2026-05-26.md
---

# Ridondanza — Notify

## Scopo del modulo

Notifiche multicanale, template email (Spatie), temi notifica, log invii. La ridondanza qui danneggia **affidabilità invio** e **chiarezza Filament admin**.

## P0 — file spuri (non autoload)

Nove file `*.php.up` — backup pre-migrazione Filament 3/5, **duplicano** classi esistenti con casing diverso:

- `NotificationTemplateResource.php.up` / `notificationtemplateresource.php.up`
- `NotificationLog.php.up` / `notificationlog.php.up`
- `notificationtemplateversion.php.up`
- `MailTemplateResource/RelationManagers/*.php.up` (4 file)

**Azione:** delete dopo verifica diff con `app/Filament/**` e `app/Models/**` attivi.

## P1 — dominio template (perplessità aperta)

| Stack | Risorsa | Modello | Note |
|-------|---------|---------|------|
| Email / Lang | `MailTemplateResource` | `MailTemplate` | Estende `LangBaseResource` |
| Notifiche | `NotificationTemplateResource` | `NotificationTemplate` | `XotBaseResource`, Filament 5 |

**Dubbio:** convergenza futura o due bounded context distinti? Serve ADR prima di unificare form/table.

**Zen:** non forzare merge solo perché i nomi sono simili — verificare campi, canali, policy invio.

## P1 — documentazione rumorosa

- Coppie `filament-pages.md` / `filament_pages.md`, `index.md` / `INDEX.md`.
- Decine di guide migrazione Filament (`migrazione-filament-4.md`, `filament4-migration.md`, …).

**Politica:** tenere **una** guida canonica in wiki; resto on-demand o `docs/wiki/_archive/` se previsto da convenzione Xot.

## Audit precedente

- [redundancy-audit-2026-05-21.md](../../../redundancy-audit-2026-05-21.md) — fragment email case, config annidate.

## Collegamenti

- [Filosofia trasversale](../../../../Xot/docs/wiki/concepts/code-redundancy-philosophy.md)
- [Audit 2026-05-26](../../../../Xot/docs/wiki/redundancy-audit-2026-05-26.md)
