# Case Sensitivity e Struttura Corretta delle Directory nei Moduli Laravel

## Problemi Identificati

Sono stati rilevati diversi problemi di struttura delle directory all'interno dei moduli Laravel:

1. **Case Sensitivity Errata**:
   - **Percorso ERRATO**: `/var/www/html/base_<nome progetto>/laravel/Modules/User/Resources`
   - **Percorso CORRETTO**: `/var/www/html/base_<nome progetto>/laravel/Modules/User/resources`

   - **Percorso ERRATO**: `/var/www/html/base_<nome progetto>/laravel/Modules/User/Config`
   - **Percorso CORRETTO**: `/var/www/html/base_<nome progetto>/laravel/Modules/User/config`

2. **Posizione Errata del Codice PHP**:
   - **Percorso ERRATO**: `/var/www/html/base_<nome progetto>/laravel/Modules/User/Filament/Widgets`
   - **Percorso CORRETTO**: `/var/www/html/base_<nome progetto>/laravel/Modules/User/app/Filament/Widgets`

## Regole Fondamentali

In Laravel e nei moduli Laravel (incluso il package nwidart/laravel-modules), le seguenti regole sono fondamentali:

1. **La case sensitivity dei nomi delle directory è cruciale** e deve essere rispettata rigorosamente.
2. **Tutto il codice PHP deve essere posizionato all'interno della sottodirectory `app` del modulo.**

### Directory Standard con Case Sensitivity e Struttura Corretta

```
Modules/NomeModulo/
├── app/                  # TUTTO il codice PHP deve essere qui
│   ├── Actions/          # Azioni (QueueableAction)
│   ├── Console/          # Comandi Artisan
│   ├── Datas/            # Data Objects
│   ├── Enums/            # Classi Enum
│   ├── Events/           # Eventi
│   ├── Filament/         # Componenti Filament
│   │   ├── Pages/
│   │   ├── Resources/
│   │   └── Widgets/      # Widget Filament (DEVE essere in app/)
│   ├── Http/             # Controllers, Middleware, ecc.
│   ├── Models/           # Modelli Eloquent
│   ├── Providers/        # Service Providers
│   └── Services/         # Servizi
├── config/               # File di configurazione (minuscolo)
├── database/             # Migrazioni, seeder, factories (minuscolo)
├── docs/                 # Documentazione (minuscolo)
├── resources/            # Risorse frontend (minuscolo)
│   ├── assets/           # Asset statici (minuscolo)
│   ├── images/           # Immagini (minuscolo)
│   ├── js/               # JavaScript (minuscolo)
│   ├── lang/             # Traduzioni (minuscolo)
│   ├── sass/             # File SASS (minuscolo)
│   └── views/            # Viste Blade (minuscolo)
└── routes/               # Route del modulo (minuscolo)
```

## Namespace Corretti

Importante: il namespace deve seguire la struttura del modulo **senza** includere il segmento `app`:

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Widgets;

// ❌ ERRATO
namespace Modules\User\App\Filament\Widgets;
```

## Impatto dei Problemi

L'utilizzo di strutture di directory errate può causare:

1. **Errori in produzione**: Su sistemi operativi case-sensitive (come Linux), i file potrebbero non essere trovati
2. **Comportamenti incoerenti**: Funziona in locale (Windows) ma non in produzione (Linux)
3. **Problemi con gli autoloader**: PSR-4 e altri autoloader potrebbero non trovare le classi
4. **Errori con i package**: Package come nwidart/laravel-modules cercano directory con nomi specifici
5. **Errori PHPStan**: L'analisi statica potrebbe fallire a causa di classi non trovate

## Come Verificare

Per verificare la corretta struttura delle directory nei moduli:

```bash

# Verifica case sensitivity errata
find /var/www/html/base_<nome progetto>/laravel/Modules -type d -name "Resources" -o -name "Config" -o -name "Views" -o -name "Lang" -o -name "Images"

# Verifica codice PHP fuori da app/
find /var/www/html/base_<nome progetto>/laravel/Modules -type d -name "Filament" -o -name "Http" -o -name "Models" | grep -v "/app/"
```

## Come Correggere

### Per problemi di case sensitivity:

```bash

# Rinomina la directory (su sistemi Linux/Unix)
mv /var/www/html/base_<nome progetto>/laravel/Modules/User/Resources /var/www/html/base_<nome progetto>/laravel/Modules/User/resources_temp
mv /var/www/html/base_<nome progetto>/laravel/Modules/User/resources_temp /var/www/html/base_<nome progetto>/laravel/Modules/User/resources

mv /var/www/html/base_<nome progetto>/laravel/Modules/User/Config /var/www/html/base_<nome progetto>/laravel/Modules/User/config_temp
mv /var/www/html/base_<nome progetto>/laravel/Modules/User/config_temp /var/www/html/base_<nome progetto>/laravel/Modules/User/config
```

### Per problemi di posizione del codice PHP:

```bash

# Crea la directory app se non esiste
mkdir -p /var/www/html/base_<nome progetto>/laravel/Modules/User/app/Filament

# Sposta i file nella posizione corretta
mv /var/www/html/base_<nome progetto>/laravel/Modules/User/Filament/Widgets /var/www/html/base_<nome progetto>/laravel/Modules/User/app/Filament/
```

## Best Practices

1. **Case Sensitivity**: Tutte le directory standard di Laravel e dei moduli devono essere in minuscolo
2. **Posizione del Codice**: Tutto il codice PHP deve essere nella sottodirectory `app`
3. **Namespace**: I namespace non devono includere il segmento `app`
4. **Verifica Prima del Deploy**: Controllare sempre la struttura prima di deployare in produzione
5. **Configurazione IDE**: Configurare l'IDE per rispettare la case sensitivity anche su Windows

## Collegamenti ad Altri Documenti

- [DIRECTORY-STRUCTURE-GUIDE.md](./DIRECTORY-STRUCTURE-GUIDE.md) - Guida completa alla struttura delle directory
- [MODULE-STRUCTURE.md](./MODULE-STRUCTURE.md) - Struttura standard dei moduli
- [naming-conventions.md](./naming-conventions.md) - Convenzioni di naming nel progetto

## Conclusione

Rispettare la struttura corretta delle directory è fondamentale per garantire la portabilità e il corretto funzionamento dell'applicazione su tutti i sistemi operativi. Queste regole vanno applicate rigorosamente in tutti i moduli del progetto il progetto.

## Collegamenti Bidirezionali

- [README.md](./README.md) - Indice principale della documentazione
- [MODULE_STRUCTURE.md](./MODULE_STRUCTURE.md) - Struttura standard dei moduli
- [NAMESPACE-RULES.md](./NAMESPACE-RULES.md) - Regole per i namespace nei moduli
- [FOLIO_VOLT_FILAMENT_INTEGRATION.md](./FOLIO_VOLT_FILAMENT_INTEGRATION.md) - Integrazione Folio, Volt e Filament
- [filament/widgets/xot-base-widget.md](./filament/widgets/xot-base-widget.md) - Documentazione su XotBaseWidget
