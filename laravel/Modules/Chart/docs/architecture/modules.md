# Architettura dei Moduli in Base

## Struttura Generale

Ogni modulo nel sistema Base è progettato come un'unità indipendente con proprio composer.json, configurazioni e documentazione. I moduli seguono una struttura standardizzata:

```
Modules/
├── NomeModulo/
│   ├── app/                    # Codice principale del modulo
│   │   ├── Filament/           # Componenti Filament
│   │   ├── Models/             # Modelli
│   │   ├── Providers/          # Service Providers
│   │   └── ...                 # Altri namespace
│   ├── config/                 # Configurazione del modulo
│   ├── database/               # Migrazioni, seeder, factories
│   ├── docs/                   # Documentazione tecnica del modulo
│   ├── lang/                   # File di traduzione
│   ├── resources/              # Assets, viste, ecc.
│   ├── routes/                 # Definizioni delle rotte
│   ├── bashscripts/            # Script di utility
│   ├── tests/                  # Test unitari e di integrazione
│   ├── composer.json           # Dipendenze e autoload del modulo
│   └── module.json             # Metadati del modulo
```

## Namespace e Autoload

- **Namespace Base**: `Modules\NomeModulo\`
- **Autoload**: Definito nel composer.json di ogni modulo
- **Importante**: Il namespace corretto è `Modules\NomeModulo\` e NON `Modules\NomeModulo\app\`

Esempio di autoload in composer.json:
```json
"autoload": {
    "psr-4": {
        "Modules\\NomeModulo\\": "app/",
        "Modules\\NomeModulo\\Database\\Factories\\": "database/factories/",
        "Modules\\NomeModulo\\Database\\Seeders\\": "database/seeders/"
    }
}
```

## Service Provider

Ogni modulo deve avere un Service Provider che estende `XotBaseServiceProvider`:

```php
namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class NomeModuloServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'NomeModulo';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    
    // Altri metodi...
}
```

## Filament Resources

Le risorse Filament devono seguire queste regole:

1. Estendere `XotBaseResource` invece di `Filament\Resources\Resource`
2. Per le funzioni `getTableActions` e `getTableBulkActions`:
   - Se `getTableActions` restituisce solo ViewAction, EditAction e DeleteAction, deve essere rimosso
   - In caso contrario, deve includere `...parent::getTableActions()`
   - Se `getTableBulkActions` restituisce solo DeleteBulkAction, deve essere rimosso
   - In caso contrario, deve includere `...parent::getTableBulkActions()`
3. Non utilizzare mai `->label('')` direttamente, gestire le label tramite file di traduzione

```php
// Esempio corretto di getTableActions personalizzato
public function getTableActions(): array
{
    return [
        ...parent::getTableActions(),
        Action::make('custom')
            ->icon('heroicon-o-bolt')
            ->action(fn (Model $record) => $this->customAction($record))
    ];
}
```

## Traduzioni

- Le etichette (label) non devono essere hardcoded nel codice
- Utilizzare file di traduzione in `lang/`
- Registrare le traduzioni tramite `LangServiceProvider`

## Documentazione

### Struttura della Documentazione

1. **Documentazione del Modulo**: 
   - Si trova nella cartella `docs/` di ogni modulo
   - Contiene la documentazione tecnica approfondita
   - Descrive funzionalità, architettura e utilizzo del modulo

2. **Documentazione Root**: 
   - Si trova nella cartella `docs/` nella root del progetto
   - Funge da indice con collegamenti bidirezionali
   - Fornisce una visione generale del progetto
   - Include roadmap, epiche, milestone e descrizione del progetto

### Regole per la Documentazione

1. **Collegamenti Bidirezionali**:
   - Ogni documento nella root deve avere collegamenti ai documenti specifici nei moduli
   - Ogni documento nei moduli deve avere collegamenti alla documentazione nella root
   - Usare sempre percorsi relativi, mai assoluti

2. **Stile di Scrittura**:
   - Concentrarsi sul "perché" e sul "cosa", non sul "come"
   - Essere concisi ed essenziali
   - Evitare dettagli implementativi non necessari

3. **Aggiornamenti**:
   - Quando si corregge/aggiorna una funzionalità, aggiornare prima la documentazione del modulo
   - Poi aggiungere/aggiornare i collegamenti nella documentazione root

### Esempio di Collegamenti Bidirezionali

Nella documentazione root (`docs/gestione-pazienti.md`):
```markdown

# Gestione Pazienti

Per dettagli tecnici, vedere la [documentazione del modulo Patient](../laravel/Modules/Patient/docs/README.md).
```

Nella documentazione del modulo (`laravel/Modules/Patient/docs/README.md`):
```markdown

# Modulo Patient

Questo modulo implementa la gestione dei pazienti come descritto nella [documentazione generale](../../../../docs/gestione-pazienti.md).
```

## Regole Generali

1. **Classi**:
   - Le classi da registrare si trovano nella cartella `app/`
   - Utilizzare tipi PHP 8.2+ per garantire robustezza (strict types)
   - Seguire le convenzioni PSR-12

2. **Script Shell**:
   - Utilizzare la cartella `bashscripts/` più vicina al modulo
   - Non creare nuove cartelle `bashscripts/`

3. **Coerenza Architetturale**:
   - Mantenere la coerenza con il resto del progetto
   - Non rompere funzionalità esistenti
   - Aggiornare la documentazione quando si apportano modifiche

4. **Performance**:
   - Ottimizzare query e caricamento delle risorse
   - Utilizzare cache dove appropriato
   - Seguire le best practices di Laravel e Filament

## Moduli Principali

- **Xot**: Core del sistema, contiene classi base e funzionalità comuni
- **User**: Gestione utenti e autorizzazioni
- **Patient**: Gestione dei pazienti e dati ISEE
- **Dental**: Gestione visite e trattamenti odontoiatrici
- **Cms**: Gestione contenuti e frontoffice
- **Tenant**: Implementazione multi-tenant
- **UI**: Componenti interfaccia utente condivisi
- **Media**: Gestione file e media
- **Reporting**: Generazione report e statistiche 

## Collegamenti tra versioni di modules.md
* [modules.md](docs/tecnico/laraxot/modules.md)
* [modules.md](docs/architecture/modules.md)
* [modules.md](laravel/Modules/Xot/docs/filament/modules.md)
* [modules.md](laravel/Modules/Xot/docs/config/modules.md)

