---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "no services no support queueable actions"
issues: []
discussions: []
title: No Services/No Support — QueueableAction
---

# Regola

`app/Services/` e `app/Support/` non esistono in questo modulo (verificato 2026-07-20). Ogni logica di dominio vive in `app/Actions/{Contesto}/FooAction.php`, con `use Spatie\QueueableAction\QueueableAction;` e unico metodo pubblico `execute()`, chiamata via `app(FooAction::class)->execute(...)`.

## Struttura reale

Sottocartelle per contesto: `Actions/Registration/`, `Actions/Validation/`, `Actions/Consent/`.

## Perché

Coerenza con la policy Laraxot: nessun layer Service, azioni a singola responsabilità, chiamabili via `app()->execute()`.
