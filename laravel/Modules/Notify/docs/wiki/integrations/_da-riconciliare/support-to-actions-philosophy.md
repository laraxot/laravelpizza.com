---
title: "da Support a Actions: Filosofia"
type: concept
tags: [support, actions, philosophy]
created: 2026-07-14
updated: 2026-07-14
qmd: "support-to-actions-philosophy da support a actions: filosofia"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "../../../00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-notify-completamento-assoluto.md"
  - "../../../acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# da Support a Actions: Filosofia

> **Aggiornato 2026-07-12:** `app/Support/` è **eliminato** nel modulo Notify. Canonico: [wiki/concepts/no-app-support-queueable-actions.md](wiki/concepts/no-app-support-queueable-actions.md).
> **Aggiornato 2026-07-12:** `app/Support/` è **eliminato** nel modulo Notify. Canonico: [wiki/concepts/no-app-support-queueable-actions.md](../../concepts/no-app-support-queueable-actions.md).

## Principio (post-migrazione)

Tutta la logica di dominio vive in **`app/Actions/`** (Spatie `QueueableAction` + `execute()`).

| Tipo | Path canonico |
|------|----------------|
| Unità di business (sync/queue) | `app/Actions/*Action.php` |
| Facade multi-metodo / coordinator | `app/Adapters/` |
| DTO / config tipizzata | `app/Datas/` |

**Vietato** ricreare `app/Support/` per helper, formatter, resolver o delivery push/mail.

## Distinzione

| Categoria | Esempi | Directory |
|-----------|--------|-----------|
| **Actions** | Invio push, mail Mailtrap, dispatch notifiche | `Actions/` |
| **Adapters** | Facade che delega a più Actions | `Adapters/` |
| **Datas** | Config immutabile, registry costanti | `Datas/` |

## Spatie QueueableAction

Tutte le classi in `app/Actions/` DEVONO:

1. Usare `Spatie\QueueableAction\QueueableAction`
2. Esporre un metodo `execute()` come entry point principale
3. Avere suffisso `*Action` (salvo eccezioni documentate nel modulo)

## Cosa abbiamo spostato (2026-07-12)

| Legacy | Destinazione |
|--------|--------------|
| `app/Support/PushNotificationPlatformDelivery.php` | `app/Actions/PushNotificationPlatformDelivery.php` |
| `app/Support/MailEngines/MailtrapEngine` | `app/Actions/Mail/SendMailtrapMailAction.php` |

## Collegamenti

- [no-app-support-queueable-actions](wiki/concepts/no-app-support-queueable-actions.md)
- [claude-audit-static](wiki/concepts/claude-audit-static.md)
- [no-app-support-queueable-actions](../../concepts/no-app-support-queueable-actions.md)
- [claude-audit-static](../../concepts/claude-audit-static.md)
- Issue [#372](https://github.com/laraxot/platform/issues/372) · Discussion [#273](https://github.com/laraxot/platform/discussions/273)
- Issue [#372](https://github.com/laraxot/<nome repitory>/issues/372) · Discussion [#273](https://github.com/laraxot/<nome repitory>/discussions/273)
