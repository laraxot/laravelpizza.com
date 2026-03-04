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
