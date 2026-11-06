---
title: Livewire → Widgets W1: User Auth twins
type: story
module: User
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, livewire, filament-widgets, user, auth, w1]
qmd: "livewire filament widgets user auth login register logout reuse policy redirect"
related:
  - ./tomorrow-handoff.story.md
  - ./livewire-widgets-w1-job.story.md
  - ../bmad/stories/livewire-to-filament-widgets-fleet.story.md
  - ../bmad/livewire-to-filament-widgets-filament-blueprint.md
  - ../../User/docs/stories/10.3.retire-auth-livewire-twins.story.md
---

<!--
GateGuard facts:
1. Supersedes nothing: W1 User Auth executable slice; complements 10.3.retire-auth-livewire-twins.
2. Linked from tomorrow-handoff.story.md and livewire-to-filament-widgets-fleet.story.md.
3. New file in existing Modules/Xot/docs/stories/; owns User Auth Livewire/Widgets.
4. User verbatim: "fa tutte le bmad stories per continuare domani"
-->

# Livewire W1: User Auth

## Perche'

Auth Livewire ha gemelli Widget. REUSE widget, ritiro HTTP a caller zero,
**senza cambiare policy/redirect**.

## Owned scope

- `Modules/User/app/Http/Livewire/**` Auth* (da inventory)
- `Modules/User/app/Filament/Widgets/Auth/**`
- Test Login page / Volt / Widget separati
- Docs User stories esito

**Non toccare:** Job Livewire, Profile/Team/Socialite (W2), semantics policy/redirect.

## Tasks

1. Inventory Auth* vive vs widget.
2. Retarget caller → Widget.
3. Ritiro HTTP solo con `rg` a zero.
4. Pest pattern separati (page / volt / widget).
5. Aggiornare fleet + handoff + 10.3 se aperta.

## Acceptance

- [ ] Auth Livewire ritirati o KEEP motivato
- [ ] Policy/redirect invariati
- [ ] Widget Auth = basi Xot
- [ ] Test auth verdi sul perimetro

## Testing strategy

LoginWidgetTest + page test; mai un test che mescola i tre surface.
