# Convenzioni di Naming

## Struttura delle Cartelle nei Moduli

### Case Sensitivity
- ✅ `resources/` (lowercase)
- ❌ `Resources/` (NO uppercase)
- ✅ `config/` (lowercase)
- ❌ `Config/` (NO uppercase)
- ✅ `app/` (lowercase)
- ❌ `App/` (NO uppercase)

La struttura corretta di un modulo deve seguire le convenzioni di Laravel per il case sensitivity:

```
Modules/
└── User/                 # PascalCase per il nome del modulo
    ├── app/             # lowercase per codice sorgente
    │   ├── Filament/    # PascalCase per namespace Filament
    │   │   ├── Resources/
    │   │   ├── Pages/
    │   │   └── Widgets/
    │   └── ...
    ├── resources/        # lowercase per cartelle standard Laravel
    │   ├── views/       # lowercase
    │   │   └── pages/   # lowercase per Folio
    │   ├── lang/        # lowercase
    │   ├── js/          # lowercase
    │   ├── css/         # lowercase
    │   └── images/      # lowercase
    ├── config/          # lowercase
    ├── database/        # lowercase
    └── docs/            # lowercase
```

### Regole Fondamentali

1. **Cartelle Standard Laravel**:
   - Usare sempre lowercase per le cartelle standard di Laravel
   - Esempi: `resources`, `config`, `database`, `routes`, `app`

2. **Nome dei Moduli**:
   - PascalCase per i nomi dei moduli
   - Esempi: `User`, `Patient`, `Dental`

3. **Sottocartelle**:
   - Lowercase per tutte le sottocartelle standard
   - PascalCase per namespace specifici (es: `Filament/`)

4. **Struttura Filament**:
   - I componenti Filament vanno in `app/Filament/`
   - Usare PascalCase per le sottocartelle di Filament
   - Esempio: `app/Filament/Resources/`, `app/Filament/Widgets/`

5. **Struttura Folio**:
   - Le pagine vanno in `resources/views/pages/`
   - Tutte le cartelle e file in lowercase
   - Usare `index.blade.php` per le pagine principali
   - Non definire rotte manualmente

### Esempi Corretti vs Errati

✅ Corretto:
```
Modules/User/resources/views/
Modules/User/config/
Modules/User/app/Filament/Widgets/
Modules/User/resources/views/pages/auth/logout.blade.php
```

❌ Errato:
```
Modules/User/Resources/views/      # NO: Resources con R maiuscola
Modules/User/Config/              # NO: Config con C maiuscola
Modules/User/Filament/Widgets/    # NO: Filament fuori da app/
Modules/User/resources/views/pages/Auth/Logout.blade.php  # NO: maiuscole
```

## Motivazioni

1. **Compatibilità**:
   - Laravel usa lowercase per le sue cartelle standard
   - Mantenere coerenza con il framework
   - Evitare problemi su sistemi case-sensitive

2. **Manutenibilità**:
   - Struttura prevedibile e coerente
   - Facilità di navigazione
   - Riduzione degli errori

3. **Deployment**:
   - Evitare problemi di deployment su sistemi Unix/Linux
   - Garantire consistenza tra ambienti diversi

4. **PSR-4 e Autoloading**:
   - Rispettare le convenzioni PSR-4
   - Facilitare l'autoloading delle classi
   - Mantenere coerenza con i namespace

## Best Practices

1. **Creazione Nuovi Moduli**:
   ```bash
   # Corretto
   php artisan module:make User
   
   # Errato
   php artisan module:make user
   ```

2. **Creazione Cartelle**:
   ```bash
   # Corretto
   mkdir -p Modules/User/resources/views/pages/auth
   mkdir -p Modules/User/app/Filament/Widgets
   
   # Errato
   mkdir -p Modules/User/Resources/Views
   mkdir -p Modules/User/Filament/Widgets
   ```

3. **Migrazione da Strutture Esistenti**:
   ```bash
   # Rinominare cartelle non conformi
   mv Modules/User/Resources Modules/User/resources_temp
   mv Modules/User/resources_temp Modules/User/resources
   
   # Spostare Filament nella posizione corretta
   mv Modules/User/Filament Modules/User/app/Filament
   ```

## Collegamenti
- [Laravel Filesystem](https://laravel.com/project_docs/filesystem)
- [Nwidart Module Structure](https://nwidart.com/laravel-modules/v6/introduction)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [Filament Documentation](https://filamentphp.com/docs)
- [Folio Documentation](https://laravel.com/project_docs/folio)

## Note Importanti
- Mantenere questa convenzione in tutti i nuovi moduli
- Aggiornare moduli esistenti per conformarsi
- Documentare eccezioni se necessarie
- Utilizzare strumenti di linting per verificare la conformità
- I componenti Filament devono sempre essere in `app/Filament/`
- Le cartelle standard Laravel devono sempre essere in lowercase
- Le pagine Folio devono seguire la struttura `resources/views/pages/` 
## Collegamenti tra versioni di CONVENTIONS.md
* [CONVENTIONS.md](../../../Xot/project_docs/CONVENTIONS.md)
* [CONVENTIONS.md](../../../Dental/project_docs/CONVENTIONS.md)
* [CONVENTIONS.md](../../../Patient/project_docs/CONVENTIONS.md)


## Collegamenti tra versioni di conventions.md
* [conventions.md](../../../../project_docs/tecnico/filament/conventions.md)
* [conventions.md](../../../../project_docs/conventions.md)
* [conventions.md](../../Dental/project_docs/conventions.md)
* [conventions.md](../../Patient/project_docs/conventions.md)

