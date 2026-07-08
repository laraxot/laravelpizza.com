# Module Architecture

> Architettura modulare Laravel per PTVX.

## 🏗️ Struttura Base

```
laravel/
├── Modules/
│   ├── Xot/           # Core framework Laraxot
│   ├── User/          # Gestione utenti
│   ├── UI/            # Componenti UI condivisi
│   ├── Ptv/           # Modulo principale PTVX
│   └── Performance/   # Gestione performance
└── Themes/One/        # Tema frontend
```

## 📦 Struttura Modulo

```
Modules/{ModuleName}/
├── app/
│   ├── Actions/           # Spatie QueueableActions
│   ├── Data/              # Spatie Laravel Data
│   ├── Filament/          # Resources, Pages, Widgets
│   ├── Models/            # Eloquent models
│   └── ...
├── database/
│   ├── migrations/
│   └── factories/
├── docs/
├── resources/
│   └── lang/
└── routes/
```

## 🔧 Estensioni Obbligatorie

```php
// ✅ CORRETTO
class UserServiceProvider extends XotBaseMigration
class User extends BaseModel
class UserResource extends XotBaseResource

// ❌ ERRATO
class User extends Illuminate\Database\Eloquent\Model
```

## 📋 Checklist Nuovo Modulo

- [ ] Struttura directory corretta
- [ ] Namespace senza segmento 'app'
- [ ] Service Provider estende XotBaseServiceProvider
- [ ] Modelli estendono BaseModel del modulo
- [ ] Repository pattern implementato
- [ ] Actions per logica di business
- [ ] Traduzioni complete (it/en/de)

## 🔗 Link

**Precedente:** [Project Context](project-context.md) | **Successivo:** [Code Style](code-style.md)

**Di ritorno:**
- [CLAUDE.md - Architecture Section](../../CLAUDE.md)
- [AGENTS.md - Module Architecture Section](../../AGENTS.md)
