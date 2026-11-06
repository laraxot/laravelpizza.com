---
title: "Registrazione dei Componenti Blade nel Modulo User"
type: concept
tags: [component, registration]
created: 2026-07-14
updated: 2026-07-14
qmd: "component-registration registrazione dei componenti blade nel modulo user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./architecture-rules.md"
  - "./architecture.md"
  - "./auth-blade-structure.md"
  - "./README.md"
  - "./structure.md"
  - "./testing-structure.md"
  - "./user-gdpr-decoupling.md"
  - "./user-gdpr-oupling.md"
status: draft
---

# Registrazione dei Componenti Blade nel Modulo User

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo User.
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/architecture/component-registration.md).
> La documentazione principale e completa si trova nel [modulo UI](../../../ui/project_docs/architecture/component-registration.md).
## Implementazione Corretta nel Modulo User
Nel modulo User, tutti i componenti Blade devono seguire la struttura standard:
```
Modules/
└── User/
    └── View/
        └── Components/
            └── Profile/
                ├── Dropdown.php
                └── DropdownLink.php
Il `UserServiceProvider` **non deve** registrare manualmente i componenti Blade, poiché questo avviene automaticamente tramite il metodo `registerBladeComponents()` ereditato da `XotBaseServiceProvider`.
## Utilizzo Corretto nel Modulo User
I componenti possono essere utilizzati nei template Blade con il prefisso del namespace:
```blade
<x-user::profile.dropdown>
    <!-- Contenuto del dropdown -->
</x-user::profile.dropdown>
## Collegamenti
- [Documentazione principale sulla registrazione dei componenti](../../../UI/docs/architecture/component-registration.md)
- [Implementazione di UserServiceProvider](../../app/Providers/UserServiceProvider.php)
- [Implementazione di UserServiceProvider](../../app/Providers/UserServiceProvider.php)
- [Documentazione principale sulla registrazione dei componenti](../../../UI/docs/architecture/component-registration.md)
- [Implementazione di UserServiceProvider](Modules/User/app/Providers/UserServiceProvider.php)
- [Documentazione principale sulla registrazione dei componenti](modules/ui/project_docs/architecture/component-registration.md)
