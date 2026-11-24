---
title: "Anti-pattern: @auth attorno a notifications"
type: prompt
module: UI
qmd: "anti-pattern livewire notifications auth wrap filament layout"
related:
  - ../bmad/stories/filament-layout-directives.story.md
  - ../../../../../../docs/wiki/memories/filament5-layout-contract-shared-modules.md
---

# Anti-pattern: `@auth` + notifications

**Sbagliato:**

```blade
@auth
    @livewire('notifications')
@endauth
```

**Corretto** (Filament 5 configuring-your-layout):

```blade
@livewire('notifications')
```

Perché: toast/session-expired devono montare sempre; `@auth` spegne il canale per ospiti e dopo logout mid-page.

In PTVX: layout UI/User (Cms assente). Nei sibling FO: `Cms/.../foot.blade.php`.
