---
issues: []
discussions: []
title: "No Services / No Support — QueueableAction only"
type: concept
module: Lang
tags: [lang, services, support, actions, queueable-action, migration]
created: 2026-07-13
updated: 2026-07-13
qmd: "Lang module Services and Support banned use app Actions QueueableAction policy"
related:
  - no-app-support-queueable-actions.md
  - lang-services-to-actions.md
  - translator-adapter-migration.md
  - ../../../Xot/docs/wiki/concepts/queueable-action-trait-mandatory.md
---

# Lang — Services/Support vietati: solo Actions

## Regola

- **Mai** creare file in `app/Services/` o `app/Support/`
- **Sempre** `app/Actions/{Contexto}/FooAction.php`
- **Trait**: `use Spatie\QueueableAction\QueueableAction;`
- **Entrypoint**: unico metodo `execute(...)`
- **Chiamata**: `app(FooAction::class)->execute(...)`
- **Gruppi**: sottocartelle per attore/contesto

## Conversione

Vedi [lang-services-to-actions.md](lang-services-to-actions.md) e [translator-adapter-migration.md](translator-adapter-migration.md) per mapping dettagliato.
