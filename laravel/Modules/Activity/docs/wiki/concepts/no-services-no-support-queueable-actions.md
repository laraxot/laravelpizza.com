---
title: "No Services / No Support — QueueableAction only"
type: concept
module: Activity
tags: [activity, services, support, actions, queueable-action, migration]
created: 2026-07-13
updated: 2026-07-13
qmd: "Activity module Services and Support banned use app Actions QueueableAction policy"
related:
  - no-app-support-queueable-actions.md
  - ../../../Xot/docs/wiki/concepts/queueable-action-trait-mandatory.md
  - ../../../Xot/docs/wiki/concepts/no-app-support-queueable-actions.md
---

# Activity — Services/Support vietati: solo Actions

## Regola

- **Mai** creare file in `app/Services/` o `app/Support/`
- **Sempre** `app/Actions/{Contexto}/FooAction.php`
- **Trait**: `use Spatie\QueueableAction\QueueableAction;`
- **Entrypoint**: unico metodo `execute(...)`
- **Chiamata**: `app(FooAction::class)->execute(...)`
- **Gruppi**: sottocartelle per attore/contesto (`Actions/Log/`, `Actions/Redact/`)

## Conversione

Vedi [no-app-support-queueable-actions.md](no-app-support-queueable-actions.md) per il mapping legacy → Action.
