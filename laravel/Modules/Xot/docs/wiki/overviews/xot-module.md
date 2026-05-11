---
title: "Xot Module — Overview Compilato"
type: overview
sources:
  - "../xot-engine.md"
  - "../module-architecture.md"
confidence: high
created: 2026-04-15
updated: 2026-04-15
tags: [xot, laraxot, architettura, base-classes, foundation]
---

# Xot Module — Overview

**Ruolo**: Il motore fondamentale di Laraxot. Nessuna logica di business, solo i mattoni.  
**Dipendenze**: Nessuna (è la foundation, carica per primo)  
**Modulo in**: `laravel/Modules/Xot/`

---

## Filosofia

> "Xot è il Motore, non il Veicolo"

Xot non contiene logica di business. Fornisce 50+ classi base, 20+ Service Provider, e 15+ Trait
che ogni altro modulo usa come fondamenta. La qualità è DNA, non opzione.

---

## Classi Base Chiave

| Classe | Scopo | Usata da |
|--------|-------|----------|
| `XotBaseModel` | Base per tutti i Model | Ogni modulo |
| `XotBaseResource` | Base per Filament Resources | Ogni pannello admin |
| `XotBaseMigration` | Base per Migration | Ogni modulo |
| `XotBaseServiceProvider` | Base per ServiceProvider | Ogni modulo |
| `XotBaseAction` | Base per Actions | Dove si usa Actions pattern |

### XotBaseModel

```php
abstract class XotBaseModel extends Model {
    use HasXotFactory;   // Factory pattern automatico
    use Updater;         // Audit: created_by, updated_by
    use RelationX;       // Relazioni advanced
    // 20+ funzionalità standard
}
```

Auto-discovery del connection name dal namespace del modulo.  
PHPStan Level 10 — type hints completi obbligatori.

---

## Layer Architecture

```
XotBaseModel (Foundation, Xot)
    ↓
BaseModel (per-Module, es. Modules/Cms/Models/XotBaseModel.php)
    ↓
Model Specifico (business logic)
```

```
XotServiceProvider (Core)
    ↓
ModuleServiceProvider (per modulo)
    ↓
Feature registration
```

---

## Pattern: Actions over Services

Xot promuove **Actions** invece di Service classes:

```php
// ❌ Service pattern (evitare)
class UserService {
    public function create(array $data): User { ... }
}

// ✅ Action pattern (Xot way)
class CreateUserAction {
    public function execute(array $data): User { ... }
}
```

Le Actions sono single-responsibility, testabili in isolamento, componibili.

---

## Trait System

Trait componibili come "mattoncini":

| Trait | Funzione |
|-------|----------|
| `HasExtraTrait` | Campi extra dinamici |
| `HasCaching` | Cache intelligente |
| `DispatchesDomainEvents` | Eventi di dominio |
| `HasQueryOptimization` | Query ottimizzate |
| `Updater` | Audit trail automatico |
| `HasXotFactory` | Factory per testing |

---

## Service Provider

`XotServiceProvider` registra ~20 servizi core:
- `CacheManager`
- `QueryOptimizer`
- `ApiResponseService`
- ... e altri

Ogni modulo ha il proprio ServiceProvider che estende `XotBaseServiceProvider`.

---

## Relazione con altri Moduli

Xot è la base di **tutto**. L'ordine di priorità nel boot:

1. `Xot` (priority 2 — prima di tutti)
2. `User` (security & identity)
3. `Cms`, `UI`, `Lang` (infrastructure)
4. Domain modules (Fixcity, Blog, etc.)

---

## Cross-Reference Wiki

- [[../../../Cms/docs/wiki/overviews/cms-module|Cms Module]] — usa XotBase*, Folio routing
- [[../../../UI/docs/wiki/overviews/ui-module|UI Module]] — componenti Filament su XotBaseResource
- [[../../../User/docs/wiki/overviews/user-module|User Module]] — authn/authz su XotBaseModel

## Raw Sources

- `docs/xot-engine.md` — filosofia e classi fondamentali (SSOT)
- `docs/module-architecture.md` — analisi completa dell'ecosistema moduli
- `docs/testing-best-practices.md` — testing con XotBase*
- `docs/00-INDEX.md` — indice modulo
