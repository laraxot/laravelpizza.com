---
title: "Filament register widget — getState and userClass create"
type: concept
sources:
confidence: high
created: 2026-06-04
updated: 2026-06-04
tags: [user, filament, register, kiss]
related:
---

# RegisterWidget KISS persist

`$data = $this->form->getState();` then `XotData::make()->getUserClass()::create($data)`.

No `validateForm()`. No thin Action wrapper. Password hash in `UserForm` dehydrate.
