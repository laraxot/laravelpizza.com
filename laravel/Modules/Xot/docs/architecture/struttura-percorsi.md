# Struttura dei percorsi nel progetto

> **Ambiente di riferimento**: ``

## 🔑 Regola Fondamentale
Tutti i percorsi assoluti DEVONO includere il segmento `laravel/` subito dopo la directory di base del progetto.

```
{componente}/{resto-del-percorso}
                                 ↑
                           segmento obbligatorio
```

## ✅ Percorsi Correttamente Formati
```
app/Models/User.php
Modules/Xot/app/Providers/XotBaseServiceProvider.php
Themes/One/resources/views/layouts/app.blade.php
resources/lang/it/validation.php
vendor/laravel/framework/src/Illuminate/Foundation/Application.php
```

## ❌ Percorsi Errati (segmento mancante)
```
app/Models/User.php
Modules/Xot/app/Providers/XotBaseServiceProvider.php
resources/lang/it/validation.php
```

## 🗂️ Anatomia del Progetto
```

├── docs/                 # Documentazione generale
└── laravel/              # ⭐ Applicazione Laravel
    ├── app/
# Struttura dei percorsi nel progetto <nome progetto>

## Regola fondamentale

**Tutti i percorsi assoluti nel progetto <nome progetto> DEVONO includere il segmento `laravel/` dopo `base_<nome progetto>/`.**

Questa regola è **ASSOLUTA** e non ammette eccezioni.

## Anatomia di un percorso corretto

```
{componente}/{resto-del-percorso}
                         ↑        ↑
                     progetto  segmento
                    principale OBBLIGATORIO
```

## Percorsi corretti vs. percorsi errati

### ✅ Percorsi CORRETTI

```
app/Models/User.php
Modules/Patient/Models/Doctor.php
Themes/One/resources/views/layouts/app.blade.php
resources/lang/it/validation.php
vendor/laravel/framework/...
```

### ❌ Percorsi ERRATI

```
app/Models/User.php
Modules/Patient/Models/Doctor.php
Themes/One/resources/views/layouts/app.blade.php
resources/lang/it/validation.php
vendor/laravel/framework/...
```

## Struttura completa del progetto

```

├── .cursor/                            # Configurazioni editor
├── .windsurf/                          # Configurazioni di sistema
├── docs/                               # Documentazione generale
└── laravel/                            # ⭐️ APPLICAZIONE LARAVEL
    ├── app/                            # Core application
    │   ├── Console/
    │   ├── Exceptions/
    │   ├── Http/
    │   ├── Models/
    │   ├── Providers/
    │   └── View/
    ├── bootstrap/                      # Bootstrap files
    ├── config/                         # Configurazioni
    ├── database/                       # Migrations, factories, seeders
    ├── Modules/                        # ⭐️ MODULI DEL PROGETTO
    │   ├── Core/
    │   ├── Patient/
    │   ├── UI/
    │   ├── User/
    │   ├── Xot/
    │   └── ...
    ├── public/                         # Public assets
    ├── resources/                      # Views, assets, lang
    ├── routes/                         # Routes
    ├── storage/                        # Storage
    ├── Themes/                         # ⭐️ TEMI DEL PROGETTO
    │   └── One/
    └── vendor/                         # Dependencies
```

## Importanza della regola

Il rispetto di questa struttura è fondamentale per:

1. **Consistenza**: Garantisce uniformità nei riferimenti ai file
2. **Chiarezza**: Rende evidente la separazione tra l'app Laravel e il resto
3. **Deployment**: Facilita le operazioni di deploy e aggiornamento
4. **Modularità**: Supporta la struttura modulare del progetto
5. **Compatibilità**: Mantiene la compatibilità con tool e script

## Rilevamento errori nei percorsi

Prima di ogni commit, eseguire questi comandi per verificare la presenza di percorsi errati:

```bash

# Verifica percorsi errati
grep -r "app" --include="*.php" laravel
grep -r "Modules" --include="*.php" laravel
grep -r "Themes" --include="*.php" laravel
grep -r "resources" --include="*.php" laravel
grep -r "app" --include="*.php" laravel
grep -r "Modules" --include="*.php" laravel
grep -r "Themes" --include="*.php" laravel
grep -r "resources" --include="*.php" laravel
```

## Correzzione automatica (opzionale)

Se si trovano percorsi errati, è possibile correggerli automaticamente con:

```bash

# Correzione automatica (uso con cautela)
find laravel -type f -name "*.php" -exec sed -i 's|app|app|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|Modules|Modules|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|Themes|Themes|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|app|app|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|Modules|Modules|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|Themes|Themes|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|app|app|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|Modules|Modules|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|Themes|Themes|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|app|app|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|Modules|Modules|g' {} \;
find laravel -type f -name "*.php" -exec sed -i 's|Themes|Themes|g' {} \;
```

## Riferimenti correlati

- [Struttura del progetto](../Xot/docs/architecture/struttura-progetto.md)
- [Regole di namespace](../Xot/docs/standards/namespace-conventions.md)
- [Autoloading](../Xot/docs/standards/psr4-compliance.md)
- [Struttura del progetto](../Xot/docs/architecture/struttura-progetto.md)
- [Regole di namespace](../Xot/docs/standards/namespace-conventions.md)
- [Autoloading](../Xot/docs/standards/psr4-compliance.md)
- [Struttura del progetto](../Xot/docs/architecture/struttura-progetto.md)
- [Regole di namespace](../Xot/docs/standards/namespace-conventions.md)
- [Autoloading](../Xot/docs/standards/psr4-compliance.md)
- [Struttura del progetto](../Xot/docs/architecture/struttura-progetto.md)
- [Regole di namespace](../Xot/docs/standards/namespace-conventions.md)
- [Autoloading](../Xot/docs/standards/psr4-compliance.md)
