# Laravel Module Folder Structure Convention

> **Regola di Struttura per Cartelle Moduli Laravel**
> 
> **Status:** Active
> **Last Updated:** 2026-06-18
> **Owner:** Development Team

---

## Regola Generale

La struttura delle cartelle nei moduli Laravel segue la convenzione standard di Laravel, con tutte le classi PHP organizzate sotto la cartella `app/`.

### Principio Fondamentale

**Tutte le classi PHP del modulo devono essere sotto `app/`**, eccetto le cartelle speciali documentate.

---

## Struttura Standard del Modulo

```
laravel/Modules/{ModuleName}/
├── app/                          ✅ CORRETTO - Tutte le classi PHP
│   ├── Actions/                  ✅ Azioni (spatie/laravel-queueable-action)
│   ├── Enums/                    ✅ Enumerazioni PHP 8.1+
│   ├── Filament/                 ✅ Componenti Filament
│   ├── Helpers/                  ✅ Helper functions (se necessario)
│   ├── Http/
│   │   ├── Controllers/          ✅ Controllers
│   │   ├── Middleware/           ✅ Middleware
│   │   ├── Requests/             ✅ Form Requests
│   │   └── Resources/            ✅ API Resources
│   ├── Models/                   ✅ Eloquent Models
│   ├── Providers/                ✅ Service Providers
│   ├── Rules/                    ✅ Validation Rules
│   ├── Services/                 ✅ Services (solo se necessario)
│   └── Traits/                   ✅ PHP Traits
├── config/                       ✅ Configurazioni
├── database/
│   ├── factories/                ✅ Model factories
│   ├── migrations/               ✅ Database migrations
│   └── seeders/                  ✅ Database seeders
├── docs/                         ✅ Documentazione
├── lang/                         ✅ Traduzioni
├── resources/
│   ├── views/                    ✅ Blade templates
│   └── assets/                   ✅ CSS, JS, images
├── routes/                       ✅ Route definitions
├── tests/                        ✅ Test files
├── _{module}.code-workspace      ✅ VS Code workspace
└── module.json                   ✅ Module manifest
```

---

## Cartelle Speciali (Root Level)

Queste cartelle **POSSONO** stare nella root del modulo per ragioni specifiche:

### ✅ `helpers/` (Xot-specific)

**Posizione:** `laravel/Modules/Xot/helpers/`

**Perché nella root:**
- Helper functions globali per tutto l'ecosistema
- Caricate tramite `files` array in `composer.json`
- Non sono classi, ma funzioni procedurali

**Esempio:**
```
laravel/Modules/Xot/
├── helpers/
│   └── xot-helpers.php
├── app/
│   └── ...
```

**Nota:** Questa è un'eccezione specifica per Xot, il modulo core.

### ✅ `Datas/`, `Services/`, `Filament/`, `packages/`, `stubs/` (Xot-specific)

**Posizione:** Root di `laravel/Modules/Xot/`

**Perché nella root:**
- Sono cartelle speciali del core framework
- Contengono risorse condivise per tutti i moduli
- Non seguono la convenzione standard perché sono parte del framework

---

## Cartelle SBAGLIATE (Da Evitare)

### ❌ Enums nella root

**SBAGLIATO:**
```
laravel/Modules/Gdpr/
├── Enums/              ❌ SBAGLIATO!
│   └── ConsentType.php
├── app/
│   └── Enums/
│       └── ConsentType.php
```

**CORRETTO:**
```
laravel/Modules/Gdpr/
├── app/
│   └── Enums/          ✅ CORRETTO
│       └── ConsentType.php
```

**Perché:**
- Enums sono classi PHP, devono stare in `app/`
- Autoloading PSR-4 punta a `app/`
- Coerenza con standard Laravel

### ❌ Altre cartelle di classi nella root

**SBAGLIATO:**
```
laravel/Modules/User/
├── Actions/            ❌ SBAGLIATO!
├── Application/        ❌ SBAGLIATO!
├── Database/           ❌ SBAGLIATO! (usare database/ minuscolo)
├── Events/             ❌ SBAGLIATO!
├── Listeners/          ❌ SBAGLIATO!
├── Models/             ❌ SBAGLIATO!
```

**CORRETTO:**
```
laravel/Modules/User/
├── app/
│   ├── Actions/        ✅ CORRETTO
│   ├── Application/    ✅ CORRETTO
│   ├── Events/         ✅ CORRETTO
│   ├── Listeners/      ✅ CORRETTO
│   └── Models/         ✅ CORRETTO
├── database/           ✅ CORRETTO (minuscolo)
│   ├── migrations/
│   └── factories/
```

---

## Eccezioni Documentate

### Xot Module (Core Framework)

Xot è il modulo core e ha una struttura speciale:

```
laravel/Modules/Xot/
├── Datas/              ✅ ECCEZIONE - Data transfer objects
├── Filament/           ✅ ECCEZIONE - Filament components
├── Services/           ✅ ECCEZIONE - Shared services
├── helpers/            ✅ ECCEZIONE - Helper functions
├── packages/           ✅ ECCEZIONE - Package stubs
├── stubs/              ✅ ECCEZIONE - Code generation stubs
├── app/                ✅ Standard Laravel app folder
└── ...
```

**Perché:**
- Xot è il framework core
- Queste cartelle contengono risorse condivise
- Non sono classi autoloadate via PSR-4

### Altri Moduli

**NESSUNA eccezione.** Tutti gli altri moduli devono seguire la struttura standard con tutto sotto `app/`.

---

## Regole di Naming

### Cartelle

| Cartella | Naming | Esempio |
|----------|--------|---------|
| Standard | PascalCase | `app/Models/`, `app/Actions/` |
| Speciali | lowercase | `helpers/`, `stubs/` (Xot only) |

### File

| Tipo | Naming | Esempio |
|------|--------|---------|
| Models | PascalCase | `User.php`, `ConsentType.php` |
| Actions | PascalCase + Action | `CreateUserAction.php` |
| Enums | PascalCase | `ConsentType.php`, `Status.php` |
| Controllers | PascalCase + Controller | `UserController.php` |

---

## Autoloading PSR-4

La configurazione `composer.json` del modulo:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\Gdpr\\": "app/",
            "Modules\\Gdpr\\Database\\Factories\\": "database/factories/",
            "Modules\\Gdpr\\Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

**Nota:** Il namespace punta a `app/`, non alla root del modulo.

---

## Checklist Conformità

Per ogni modulo:

### Struttura Base

- [ ] Tutte le classi PHP sono sotto `app/`
- [ ] Enums sono in `app/Enums/`
- [ ] Models sono in `app/Models/`
- [ ] Controllers sono in `app/Http/Controllers/`
- [ ] Actions sono in `app/Actions/`

### Eccezioni (Xot only)

- [ ] `helpers/` nella root (solo Xot)
- [ ] `Datas/` nella root (solo Xot)
- [ ] `Services/` nella root (solo Xot)
- [ ] `Filament/` nella root (solo Xot)

### Da Rimuovere

- [ ] Nessuna cartella `Enums/` nella root
- [ ] Nessuna cartella `Models/` nella root
- [ ] Nessuna cartella `Actions/` nella root
- [ ] Nessun duplicato di cartelle sotto `app/`

---

## Esempi Reali

### ✅ Modulo Gdpr (Corretto dopo cleanup)

```
laravel/Modules/Gdpr/
├── app/
│   ├── Actions/
│   ├── Enums/
│   │   └── ConsentType.php       ✅ CORRETTO
│   ├── Filament/
│   │   └── Resources/
│   ├── Models/
│   │   └── Consent.php
│   └── Providers/
│       └── GdprServiceProvider.php
├── config/
├── database/
├── docs/
├── lang/
├── resources/
├── routes/
├── tests/
├── _gdpr.code-workspace
└── module.json
```

### ✅ Modulo Xot (Core - Eccezione)

```
laravel/Modules/Xot/
├── Datas/                          ✅ ECCEZIONE XOT
├── Filament/                       ✅ ECCEZIONE XOT
├── helpers/                        ✅ ECCEZIONE XOT
│   └── xot-helpers.php
├── Services/                       ✅ ECCEZIONE XOT
├── app/
│   ├── Actions/
│   ├── Enums/
│   ├── Models/
│   │   └── XotBaseModel.php
│   └── ...
└── ...
```

### ❌ Modulo Gdpr (Prima del cleanup)

```
laravel/Modules/Gdpr/
├── Enums/                          ❌ SBAGLIATO!
│   └── ConsentType.php            ❌ Duplicato
├── app/
│   └── Enums/
│       └── ConsentType.php        ✅ Questo è corretto
└── ...
```

---

## Migration Guide

### Se trovi cartelle nella root:

1. **Identificare il tipo di cartella:**
   - È una cartella di classi PHP? → Spostare sotto `app/`
   - È una delle eccezioni Xot? → Lasciare nella root
   - È duplicata? → Rimuovere quella nella root

2. **Spostare (se necessario):**
   ```bash
   # Esempio: spostare Enums sotto app/
   cd laravel/Modules/Gdpr
   mkdir -p app/Enums
   mv Enums/*.php app/Enums/
   rmdir Enums
   ```

3. **Verificare namespace:**
   - Controllare che i namespace nei file siano corretti
   - Esempio: `namespace Modules\Gdpr\Enums;`

4. **Eseguire dump autoload:**
   ```bash
   composer dump-autoload
   ```

5. **Testare:**
   ```bash
   php artisan test
   phpstan analyse
   ```

---

## Violazioni Note

| Modulo | Violazione | Status | Fix Date |
|--------|------------|--------|----------|
| Gdpr | `Enums/` nella root | ✅ Risolto | 2026-03-13 |
| User | `Actions/`, `Application/`, `Database/`, `Events/`, `Listeners/` nella root | ✅ Risolto | 2026-06-18 |

---

## Riferimenti

### Documenti Correlati

- [Workspace Naming Convention](conventions/workspace-naming.md)
- [Project Structure](../../docs/project/structure.md)
- [AGENTS.md](../../AGENTS.md)

### Laravel Documentation

- [Laravel Folder Structure](https://laravel.com/docs/structure)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [Laravel Packages](https://laravel.com/docs/packages)

---

*Ultimo aggiornamento: 2026-03-13*
