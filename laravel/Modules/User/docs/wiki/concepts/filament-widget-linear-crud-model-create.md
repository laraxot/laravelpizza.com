---
title: "RegisterWidget — create lineare, no Action"
type: concept
confidence: high
created: 2026-06-04
updated: 2026-06-04
tags: [user, filament, register, kiss]
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-resource-form-delegation.md"
  - "./folio-pages-owner-pattern.md"
---

# Persistenza register — `::create($data)`

`RegisterWidget::submit()` — pattern canonico:

```php
$userClass = XotData::make()->getUserClass();
$user = $userClass::create($this->form->getState());
```

Poi (solo orchestrazione widget): transaction, activity, `Auth::login`, redirect.

Default FO (`type`, `state`) in `UserForm` via `Hidden::make()->default(...)`.

ADR: [filament-widget-linear-crud-model-create.md](../../../../../../docs/wiki/decisions/filament-widget-linear-crud-model-create.md)
