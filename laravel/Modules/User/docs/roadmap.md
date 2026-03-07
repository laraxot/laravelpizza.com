# User Module - Roadmap

"Proteggere l'identità: il fondamento della fiducia."

## Visione

## 🧪 Testing e TDD

### Principi TDD
- **Red-Green-Refactor**: Test che fallisce → Codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage**: Minimo 80%, 100% per flussi Auth

### Struttura Test
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

### Best Practices
- [ ] Usare `RefreshDatabase` per test database
- [ ] Fake servizi esterni (Auth, Socialite)
- [ ] Test naming descrittivo
- [ ] Test flussi Auth completi (login, logout, register, password reset)
- [ ] Browser test per flussi E2E

### Comandi
```bash
# Test modulo
./vendor/bin/pest Modules/User/tests

# Test con coverage
./vendor/bin/pest Modules/User/tests --coverage --min=80

# Test specifico flusso auth
./vendor/bin/pest Modules/User/tests/Feature/Authentication
```

## 🧪 Testing e TDD

### Principi TDD
- **Red-Green-Refactor**: Test che fallisce → Codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage**: Minimo 80%, 100% per flussi Auth

### Struttura Test
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

### Best Practices
- [ ] Usare `RefreshDatabase` per test database
- [ ] Fake servizi esterni (Auth, Socialite)
- [ ] Test naming descrittivo
- [ ] Test flussi Auth completi (login, logout, register, password reset)
- [ ] Browser test per flussi E2E

### Comandi
```bash
# Test modulo
./vendor/bin/pest Modules/User/tests

# Test con coverage
./vendor/bin/pest Modules/User/tests --coverage --min=80

# Test specifico flusso auth
./vendor/bin/pest Modules/User/tests/Feature/Authentication
```

## 🧪 Testing e TDD

### Principi TDD
- **Red-Green-Refactor**: Test che fallisce → Codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage**: Minimo 80%, 100% per flussi Auth

### Struttura Test
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

### Best Practices
- [ ] Usare `RefreshDatabase` per test database
- [ ] Fake servizi esterni (Auth, Socialite)
- [ ] Test naming descrittivo
- [ ] Test flussi Auth completi (login, logout, register, password reset)
- [ ] Browser test per flussi E2E

### Comandi
```bash
# Test modulo
./vendor/bin/pest Modules/User/tests

# Test con coverage
./vendor/bin/pest Modules/User/tests --coverage --min=80

# Test specifico flusso auth
./vendor/bin/pest Modules/User/tests/Feature/Authentication
```

## 🏗️ Fasi di Sviluppo (.)

### Fase 1: Stability & Security (In Progress)
- [x] PHPStan Level 10 Compliance
- [x] Standardizzazione pattern ID (autoincrement) e UUID per profili
- [ ] Rimozione file obsoleti
- [ ] Implementazione Security Cluster Filament v5
- [ ] Supporto completo Laravel 12 Authentication Features
||||||| parent of da38c10 (.)
- [x] PHPStan Level 10 Compliance.
- [ ] Rimozione definitiva dei 550+ file obsoleti.
- [ ] Implementazione del **Security Cluster** in Filament v5.
- [ ] Supporto completo per **Laravel 12 Authentication Features**. (.)

### Fase 2: Modern Identity (Planned)
- [ ] Integrazione WebAuthn per login biometrici (TouchID, FaceID)
- [ ] Socialite Cluster: aggiunta provider OAuth (Google, Apple)
- [ ] Sistema Impersonation sicuro per supporto tecnico

### Fase 3: AI Moderation (Future)
- [ ] AI Identity Verification: verifica automatica documenti
- [ ] Anomaly Detection: rilevamento login sospetti
- [ ] Dynamic Permissions: AI suggerisce permessi minimi

## Technical Debt

| Area | Stato | Target |
|------|-------|--------|
| File obsoleti | 550+ | 0 |
| Security Cluster | Da implementare | Filament v5 Cluster |
| Test Auth | Parziale | 100% flussi critici |
| Passport/Sanctum | In uso | Auditing token |

## Dipendenze

- **Xot**: XotBaseResource, XotBasePage
- **Gdpr**: Consensi registrazione
- **Tenant**: Multi-tenant (se attivo)
======= (.)

## Collegamenti

- [README](README.md)
||||||| parent of da38c10 (.)
## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] 100% test coverage sui flussi critici di Auth.
- [ ] Auditing delle chiavi segrete e dei token (Passport/Sanctum). (.)
- [Login Widget Conversion](login-widget-conversion.md)
- [Namespace Conventions](namespace-conventions.md)

## Checklist Qualità

- [x] PHPStan Level 10
- [ ] 100% test coverage sui flussi critici di Auth
- [ ] Auditing delle chiavi segrete e dei token (Passport/Sanctum)

---

**
**Versione**: 1.0.0
**Maintainer**: User Module Team
**Status**: 🚧 In Development (70% completo) c76fdae73 (.)
