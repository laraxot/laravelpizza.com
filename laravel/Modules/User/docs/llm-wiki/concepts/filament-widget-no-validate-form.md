---
title: "Filament register widget — getState and userClass create"
type: concept
sources:
  - ../../../app/Filament/Widgets/Auth/RegisterWidget.php
  - ../../../app/Filament/Resources/UserResource/Schemas/UserForm.php
confidence: high
created: 2026-06-04
updated: 2026-06-04
tags: [user, filament, register, kiss]
related:
  - ../../../../../../docs/wiki/decisions/filament-widget-no-validate-form.md
  - ../../../../../../docs/wiki/decisions/filament-widget-linear-crud-model-create.md
  - ../../wiki/concepts/filament-widget-linear-crud-model-create.md
---

# RegisterWidget KISS persist

`$data = $this->form->getState();` then `XotData::make()->getUserClass()::create($data)`.

No `validateForm()`. No thin Action wrapper. Password hash in `UserForm` dehydrate.
