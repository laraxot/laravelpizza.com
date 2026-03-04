# Guida alla Struttura Corretta delle Directory nei Moduli Laraxot <nome progetto>

## Panoramica

In Laraxot <nome progetto>, la struttura delle directory di ogni modulo è cruciale per il corretto funzionamento dell'autoloading, la compatibilità con PHPStan e la manutenibilità del codice.

## Regola Fondamentale

**Tutto il codice PHP deve essere posizionato all'interno della sottodirectory `app` del modulo.**

Questa regola non è solo una convenzione di Laraxot, ma segue la struttura standard di Laravel, dove tutto il codice dell'applicazione si trova nella directory `app`.

## Struttura Corretta

```
Modules/NomeModulo/
├── app/                         # TUTTO il codice PHP deve essere qui
│   ├── Actions/                 # Azioni (QueueableAction)
│   ├── Console/                 # Comandi Artisan
│   │   └── Commands/
│   ├── Datas/                   # Data Objects (Spatie Laravel Data)
│   ├── Enums/                   # Classi Enum
│   ├── Events/                  # Eventi
│   ├── Filament/
│   │   ├── Pages/
│   │   └── Resources/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/                  # Modelli Eloquent
│   ├── Providers/               # Service Providers
│   └── ...                      # Altre directory di codice
├── config/                      # File di configurazione
├── database/                    # Migrazioni, seeder e factories
├── docs/                        # Documentazione specifica del modulo
├── resources/                   # Risorse frontend (viste, assets, ecc.)
└── routes/                      # Route del modulo
```

## Errori Comuni

### Posizionamento di Codice nella Radice del Modulo

#### ❌ ERRATO
```
Modules/Rating/Enums/SupportedLocale.php
Modules/Rating/Models/User.php
Modules/Rating/Http/Controllers/UserController.php
```

#### ✅ CORRETTO
```
Modules/Rating/app/Enums/SupportedLocale.php
Modules/Rating/app/Models/User.php
Modules/Rating/app/Http/Controllers/UserController.php
```

### Namespace non Corrispondente alla Struttura

Ricordare che il namespace deve seguire la struttura del modulo **senza** includere il segmento `app`:

#### ❌ ERRATO
```php
namespace Modules\Rating\App\Models;

class User extends Model
{
    // ...
}
```

#### ✅ CORRETTO
```php
namespace Modules\Rating\Models;

class User extends Model
{
    // ...
}
```

## Eccezioni alla Regola

Alcune directory sono escluse da questa regola:

1. **config/**: File di configurazione
2. **database/**: Migrazioni, seeder e factories
3. **routes/**: Definizioni delle route
4. **resources/**: Viste, traduzioni, assets
5. **docs/**: Documentazione

## Verifica della Struttura

Prima di eseguire PHPStan o fare commit, verifica la correttezza della struttura del tuo modulo:

```bash
find Modules/NomeModulo -type f -name "*.php" | grep -v "/app/" | grep -v "/config/" | grep -v "/database/" | grep -v "/routes/" | grep -v "/resources/" | grep -v "/docs/"
```

Se questo comando restituisce dei file, significa che sono posizionati in modo errato.

## Correzione Automatica

Per correggere automaticamente la struttura delle directory, utilizza lo script fornito:

```bash
./bashscripts/fix_directory_structure.sh NomeModulo
```

## Checklist Pre-PHPStan

1. ☐ Verifica che tutti i file PHP siano nella directory `app`
2. ☐ Assicurati che i namespace non includano il segmento `app`
3. ☐ Controlla che le relazioni tra classi e directory siano corrette
4. ☐ Esegui gli script di correzione automatica se necessario

## Perché Questa Struttura è Importante

1. **Compatibilità con Laravel**: Segue le convenzioni standard di Laravel
2. **Autoloading Corretto**: Il PSR-4 autoloader è configurato per cercare le classi in `app/`
3. **Compatibilità con PHPStan**: Evita errori di classi non trovate durante l'analisi statica
4. **Manutenibilità**: Struttura coerente e prevedibile per tutti i moduli
5. **Chiarezza**: Separazione netta tra codice applicativo e supporto (config, routes, ecc.)
