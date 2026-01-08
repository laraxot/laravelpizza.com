# Struttura dei percorsi nel progetto 

> **Ambiente di riferimento**: `/var/www/_bases/base_ptvx_fila4_mono/`

## 🔑 Regola Fondamentale
Tutti i percorsi assoluti DEVONO includere il segmento `laravel/` subito dopo la directory di base del progetto.

```
/var/www/_bases/base_ptvx_fila4_mono/laravel/{componente}/{resto-del-percorso}
                                 ↑
                           segmento obbligatorio
```

## ✅ Percorsi Correttamente Formati
```
/var/www/_bases/base_ptvx_fila4_mono/laravel/app/Models/User.php
/var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php
/var/www/_bases/base_ptvx_fila4_mono/laravel/Themes/One/resources/views/layouts/app.blade.php
/var/www/_bases/base_ptvx_fila4_mono/laravel/resources/lang/it/validation.php
/var/www/_bases/base_ptvx_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Application.php
```

## ❌ Percorsi Errati (segmento mancante)
```
/var/www/_bases/base_ptvx_fila4_mono/app/Models/User.php
/var/www/_bases/base_ptvx_fila4_mono/Modules/Xot/app/Providers/XotBaseServiceProvider.php
/var/www/_bases/base_ptvx_fila4_mono/resources/lang/it/validation.php
```

## 🗂️ Anatomia del Progetto
```
/var/www/_bases/base_ptvx_fila4_mono/
├── docs/                 # Documentazione generale
└── laravel/              # ⭐ Applicazione Laravel
    ├── app/
# Struttura dei percorsi nel progetto SaluteOra

## Regola fondamentale

**Tutti i percorsi assoluti nel progetto SaluteOra DEVONO includere il segmento `laravel/` dopo `base_saluteora/`.**

Questa regola è **ASSOLUTA** e non ammette eccezioni.

## Anatomia di un percorso corretto

```
/var/www/html/base_saluteora/laravel/{componente}/{resto-del-percorso}
                         ↑        ↑
                     progetto  segmento
                    principale OBBLIGATORIO
```

## Percorsi corretti vs. percorsi errati

### ✅ Percorsi CORRETTI

```
/var/www/html/base_saluteora/laravel/app/Models/User.php
/var/www/html/base_saluteora/laravel/Modules/Patient/Models/Doctor.php
/var/www/html/base_saluteora/laravel/Themes/One/resources/views/layouts/app.blade.php
/var/www/html/base_saluteora/laravel/resources/lang/it/validation.php
/var/www/html/base_saluteora/laravel/vendor/laravel/framework/...
```

### ❌ Percorsi ERRATI

```
/var/www/html/base_saluteora/app/Models/User.php
/var/www/html/base_saluteora/Modules/Patient/Models/Doctor.php
/var/www/html/base_saluteora/Themes/One/resources/views/layouts/app.blade.php
/var/www/html/base_saluteora/resources/lang/it/validation.php
/var/www/html/base_saluteora/vendor/laravel/framework/...
```

## Struttura completa del progetto

```
/var/www/html/base_saluteora/
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
grep -r "/var/www/html/base_techplanner_fila3_mono/app" --include="*.php" /var/www/html/base_techplanner_fila3_mono/laravel
grep -r "/var/www/html/base_techplanner_fila3_mono/Modules" --include="*.php" /var/www/html/base_techplanner_fila3_mono/laravel
grep -r "/var/www/html/base_techplanner_fila3_mono/Themes" --include="*.php" /var/www/html/base_techplanner_fila3_mono/laravel
grep -r "/var/www/html/base_techplanner_fila3_mono/resources" --include="*.php" /var/www/html/base_techplanner_fila3_mono/laravel
grep -r "/var/www/html/base_saluteora/app" --include="*.php" /var/www/html/base_saluteora/laravel
grep -r "/var/www/html/base_saluteora/Modules" --include="*.php" /var/www/html/base_saluteora/laravel
grep -r "/var/www/html/base_saluteora/Themes" --include="*.php" /var/www/html/base_saluteora/laravel
grep -r "/var/www/html/base_saluteora/resources" --include="*.php" /var/www/html/base_saluteora/laravel
```

## Correzzione automatica (opzionale)

Se si trovano percorsi errati, è possibile correggerli automaticamente con:

```bash

# Correzione automatica (uso con cautela)
find /var/www/html/base_techplanner_fila3_mono/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_techplanner_fila3_mono/app|/var/www/html/base_techplanner_fila3_mono/laravel/app|g' {} \;
find /var/www/html/base_techplanner_fila3_mono/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_techplanner_fila3_mono/Modules|/var/www/html/base_techplanner_fila3_mono/laravel/Modules|g' {} \;
find /var/www/html/base_techplanner_fila3_mono/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_techplanner_fila3_mono/Themes|/var/www/html/base_techplanner_fila3_mono/laravel/Themes|g' {} \;
find /var/www/html/base_saluteora/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_saluteora/app|/var/www/html/base_saluteora/laravel/app|g' {} \;
find /var/www/html/base_saluteora/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_saluteora/Modules|/var/www/html/base_saluteora/laravel/Modules|g' {} \;
find /var/www/html/base_saluteora/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_saluteora/Themes|/var/www/html/base_saluteora/laravel/Themes|g' {} \;
find /var/www/html/base_techplanner_fila3_mono/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_techplanner_fila3_mono/app|/var/www/html/base_techplanner_fila3_mono/laravel/app|g' {} \;
find /var/www/html/base_techplanner_fila3_mono/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_techplanner_fila3_mono/Modules|/var/www/html/base_techplanner_fila3_mono/laravel/Modules|g' {} \;
find /var/www/html/base_techplanner_fila3_mono/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_techplanner_fila3_mono/Themes|/var/www/html/base_techplanner_fila3_mono/laravel/Themes|g' {} \;
find /var/www/html/base_saluteora/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_saluteora/app|/var/www/html/base_saluteora/laravel/app|g' {} \;
find /var/www/html/base_saluteora/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_saluteora/Modules|/var/www/html/base_saluteora/laravel/Modules|g' {} \;
find /var/www/html/base_saluteora/laravel -type f -name "*.php" -exec sed -i 's|/var/www/html/base_saluteora/Themes|/var/www/html/base_saluteora/laravel/Themes|g' {} \;
```

## Riferimenti correlati

- [Struttura del progetto](../Xot/docs/architecture/struttura-progetto.md)
- [Regole di namespace](../Xot/docs/standards/namespace-conventions.md)
- [Autoloading](../Xot/docs/standards/psr4-compliance.md)
- [Struttura del progetto](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/architecture/struttura-progetto.md)
- [Regole di namespace](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/standards/namespace-conventions.md)
- [Autoloading](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/standards/psr4-compliance.md)
- [Struttura del progetto](../Xot/docs/architecture/struttura-progetto.md)
- [Regole di namespace](../Xot/docs/standards/namespace-conventions.md)
- [Autoloading](../Xot/docs/standards/psr4-compliance.md)
- [Struttura del progetto](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/architecture/struttura-progetto.md)
- [Regole di namespace](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/standards/namespace-conventions.md)
- [Autoloading](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/standards/psr4-compliance.md)
