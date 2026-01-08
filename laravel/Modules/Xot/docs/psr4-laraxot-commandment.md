# 🚨 COMANDAMENTO PSR-4 LARAXOT - STRUTTURA SACRA

## 📖 REGOLA FONDAMENTALE

**TUTTO il codice PHP deve stare in `app/` - MAI in `tests/`, `database/`, `docs/`**

Questo non è un suggerimento, è un **COMANDAMENTO** della religione Laraxot.

## ❌ VIOLAZIONI GRAVISSIME

### 1. Tests in `tests/` (SBAGLIATO)
```
❌ SBAGLIATO:
Modules/User/tests/Feature/UserTest.php
Modules/User/tests/Unit/Models/UserTest.php

✅ CORRETTO:
Modules/User/app/Tests/Feature/UserTest.php
Modules/User/app/Tests/Unit/Models/UserTest.php
```

### 2. Seeders in `database/Seeders/` (SBAGLIATO)
```
❌ SBAGLIATO:
Modules/User/database/Seeders/UserSeeder.php

✅ CORRETTO:
Modules/User/app/Database/Seeders/UserSeeder.php
```

### 3. Factories in `database/Factories/` (SBAGLIATO)
```
❌ SBAGLIATO:
Modules/User/database/Factories/UserFactory.php

✅ CORRETTO:
Modules/User/app/Database/Factories/UserFactory.php
```

### 4. Classi in `docs/` (SBAGLIATISSIMO)
```
❌ SBAGLIATO:
Modules/User/docs/MyClass.php

✅ CORRETTO:
Modules/User/app/MyClass.php
# O documentazione vera:
Modules/User/docs/my-class.md
```

## 🏛️ FILOSOFIA DIETRO LA REGOLA

### 1. **Autoloading PSR-4**
- PSR-4 richiede mappatura `Modules\\*\\` → `Modules/*/app/`
- La root `composer.json` non deve dichiarare `Modules\\`: `Modules/`: ogni modulo registra il proprio autoload verso `app/`, così composer non tenta di caricare classi da `docs/`, `tests/` o directory legacy.
- Composer non trova classi fuori da `app/`
- Laravel non può autoloader codice in posizioni errate

### 2. **Separazione Responsabilità**
- `app/` = Codice PHP eseguibile
- `tests/` = SOLO per PHPUnit configuration (non classi)
- `database/` = SOLO migration files
- `docs/` = SOLO documentazione `.md`

### 3. **Coerenza Framework**
- Tutti i moduli seguono stessa struttura
- Prevedibilità e manutenibilità
- Integrazione con IDE e strumenti

## 🔄 PATTERN CORRETTO LARAXOT

```
Modules/{ModuleName}/
├── app/                           # TUTTO il codice PHP
│   ├── Models/                   # Modelli Eloquent
│   ├── Actions/                  # Azioni Spatie
│   ├── Enums/                    # Enum PHP
│   ├── Services/                 # Servizi
│   ├── Filament/                 # Componenti Filament
│   │   ├── Resources/
│   │   ├── Widgets/
│   │   └── Tables/
│   │       └── Columns/
│   ├── Tests/                    # TEST CLASSI PHP
│   │   ├── Feature/
│   │   ├── Unit/
│   │   └── TestCase.php
│   ├── Database/                 # DATABASE CLASSI PHP
│   │   ├── Seeders/
│   │   └── Factories/
│   └── Console/                  # Comandi Artisan
├── database/                     # SOLO migration files
│   └── migrations/
├── tests/                        # SOLO config PHPUnit
│   └── Pest.php
├── docs/                         # SOLO documentazione .md
│   ├── guide.md
│   └── examples.md
└── lang/                         # Traduzioni
    ├── en/
    └── it/
```

## ⚡ AZIONE IMMEDIATA RICHIESTA

### 1. SPOSTARE Tutti i Tests
```bash
# Sposta tutti i test da tests/ a app/Tests/
find Modules/ -name "*.php" -path "*/tests/*" -exec bash -c '
  file="{}"
  dir=$(dirname "$file")
  new_dir=$(echo "$dir" | sed "s|/tests/|/app/Tests/|")
  mkdir -p "$new_dir"
  mv "$file" "$new_dir/"
' \;
```

### 2. SPOSTARE Tutti i Seeders
```bash
# Sposta tutti i seeders da database/Seeders/ a app/Database/Seeders/
find Modules/ -name "*.php" -path "*/database/Seeders/*" -exec bash -c '
  file="{}"
  dir=$(dirname "$file")
  new_dir=$(echo "$dir" | sed "s|/database/Seeders/|/app/Database/Seeders/|")
  mkdir -p "$new_dir"
  mv "$file" "$new_dir/"
' \;
```

### 3. SPOSTARE Tutte le Factories
```bash
# Sposta tutte le factories da database/Factories/ a app/Database/Factories/
find Modules/ -name "*.php" -path "*/database/Factories/*" -exec bash -c '
  file="{}"
  dir=$(dirname "$file")
  new_dir=$(echo "$dir" | sed "s|/database/Factories/|/app/Database/Factories/|")
  mkdir -p "$new_dir"
  mv "$file" "$new_dir/"
' \;
```

### 4. ELIMINARE Classi da docs/
```bash
# Rimuovi tutte le classi PHP da docs/
find Modules/ -name "*.php" -path "*/docs/*" -delete
```

## 🔍 VERIFICA POST-CORREZIONE

```bash
# Verifica che non ci siano più violazioni PSR-4
composer dump-autoload
./vendor/bin/phpstan analyse Modules/ --level=1 --no-progress
```

## 📋 OBBIETTIVO

**Zero violazioni PSR-4** - Tutte le classi devono essere autoloadabili correttamente.

## ⚖️ CONSEGUENZE VIOLAZIONE

1. **Autoloading Fallito**: Classi non trovate
2. **PHPStan Errori**: Analisi statica impossibile
3. **IDE Confusion**: Code completion non funziona
4. **Deployment Broken**: Applicazione non parte

## 📚 RIFERIMENTI

- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Laravel Module Structure](./module-structure.md)
- [Laraxot Philosophy](./philosophy.md)

---

*Questa regola è FONDAMENTALE per il funzionamento del sistema. Violarla = sistema rotto.*
