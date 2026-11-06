---
title: "Testing e TDD - User Module"
type: concept
tags: [testing]
created: 2026-07-14
updated: 2026-07-14
qmd: "testing testing e tdd - user module"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-roadmap-user.md"
  - "./00-index.md"
  - "./00-overview.md"
  - "./01-current-state.md"
  - "./01-now.md"
  - "./02-goals.md"
  - "./02-next.md"
  - "./03-later.md"
status: draft
---

# Testing e TDD - User Module

## Principi TDD

- **Red-Green-Refactor**: Test che fallisce → Codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage**: Minimo 80%, 100% per flussi Auth

## Struttura Test

```
Modules/User/tests/
├── Unit/
│   ├── Actions/
│   ├── Models/
│   │   └── UserTest.php
│   └── Services/
├── Feature/
│   ├── Authentication/
│   │   ├── LoginTest.php
│   │   ├── RegisterTest.php
│   │   └── LogoutTest.php
│   ├── Filament/
│   │   └── UserResourceTest.php
│   └── Pages/
├── Browser/
│   └── AuthenticationTest.php
├── Pest.php
└── TestCase.php
```

## Best Practices

- [ ] Usare `RefreshDatabase` per test database
- [ ] Fake servizi esterni (Auth, Socialite)
- [ ] Test naming descrittivo
- [ ] Test flussi Auth completi (login, logout, register, password reset)
- [ ] Browser test per flussi E2E

## Comandi

```bash
./vendor/bin/pest Modules/User/tests
./vendor/bin/pest Modules/User/tests --coverage --min=80
./vendor/bin/pest Modules/User/tests/Feature/Authentication
```
