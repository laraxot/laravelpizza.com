---
title: "No Services / No Support — QueueableAction only"
type: concept
module: User
tags: [user, services, support, actions, queueable-action, migration]
created: 2026-07-13
updated: 2026-07-13
qmd: "User module Services and Support banned use app Actions QueueableAction policy"
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
---

# User — Services/Support vietati: solo Actions

## Regola

- **Mai** creare file in `app/Services/` o `app/Support/`
- **Sempre** `app/Actions/{Contexto}/FooAction.php`
- **Trait**: `use Spatie\QueueableAction\QueueableAction;`
- **Entrypoint**: unico metodo `execute(...)`
- **Chiamata**: `app(FooAction::class)->execute(...)`
- **Gruppi**: sottocartelle per attore/contesto (es. `Actions/Otp/`, `Actions/Socialite/`)

## Conversione

Vedi [no-app-support-queueable-actions.md](no-app-support-queueable-actions.md) per il mapping legacy → Action.
