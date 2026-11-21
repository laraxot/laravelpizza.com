---
title: "Coverage floor 50% — perimetro offline User"
module: User
type: concept
status: approved
language: it-IT
created: 2026-08-20
updated: 2026-08-20
qmd: "coverage floor 50 user phpunit exclude filament socialite console http view"
related:
  - ../../Xot/docs/testing-coverage-floor.md
  - ./testing.md
---

# Coverage floor 50% — perimetro offline User

Esclusioni in `Modules/User/phpunit.xml` (solo path non eseguibili offline):

- Console, Http, View, Listeners, Livewire, Events, Observers, Notifications
- Models/Traits (HasTeams), Support, Adapters
- Pagine Filament Socialite/Passport/Widgets (Livewire full stack)
- ShieldUtilsAction (Spatie Shield runtime)

Si preferisce testare: policies, actions execute, Filament schema keyed, enums, datas.
