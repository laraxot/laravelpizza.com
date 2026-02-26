# Filament

Questa cartella contiene la documentazione relativa all'implementazione di Filament nel progetto.

## File Contenuti

- `resources.md` - Struttura delle risorse Filament
- `widgets.md` - Widget e componenti personalizzati
- `forms.md` - Form e validazione
- `tables.md` - Tabelle e azioni di massa

## Note

Questa documentazione si applica a tutti i moduli che utilizzano Filament per il backend. 

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/project_docs/README.md)
* [README.md](bashscripts/project_docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/project_docs/README.md)
* [README.md](../../../Chart/project_docs/README.md)
* [README.md](../../../Reporting/project_docs/README.md)
* [README.md](../../../Gdpr/project_docs/phpstan/README.md)
* [README.md](../../../Gdpr/project_docs/README.md)
* [README.md](../../../Notify/project_docs/phpstan/README.md)
* [README.md](../../../Notify/project_docs/README.md)
* [README.md](../../../Xot/project_docs/filament/README.md)
* [README.md](../../../Xot/project_docs/phpstan/README.md)
* [README.md](../../../Xot/project_docs/exceptions/README.md)
* [README.md](../../../Xot/project_docs/README.md)
* [README.md](../../../Xot/project_docs/standards/README.md)
* [README.md](../../../Xot/project_docs/conventions/README.md)
* [README.md](../../../Xot/project_docs/development/README.md)
* [README.md](../../../Dental/project_docs/README.md)
* [README.md](../../../User/project_docs/phpstan/README.md)
* [README.md](../../../User/project_docs/README.md)
* [README.md](../../../User/project_docs/README.md)
* [README.md](../../../UI/project_docs/phpstan/README.md)
* [README.md](../../../UI/project_docs/README.md)
* [README.md](../../../UI/project_docs/standards/README.md)
* [README.md](../../../UI/project_docs/themes/README.md)
* [README.md](../../../UI/project_docs/components/README.md)
* [README.md](../../../Lang/project_docs/phpstan/README.md)
* [README.md](../../../Lang/project_docs/README.md)
* [README.md](../../../Job/project_docs/phpstan/README.md)
* [README.md](../../../Job/project_docs/README.md)
* [README.md](../../../Media/project_docs/phpstan/README.md)
* [README.md](../../../Media/project_docs/README.md)
* [README.md](../../../Tenant/project_docs/phpstan/README.md)
* [README.md](../../../Tenant/project_docs/README.md)
* [README.md](../../../Activity/project_docs/phpstan/README.md)
* [README.md](../../../Activity/project_docs/README.md)
* [README.md](../../../Patient/project_docs/README.md)
* [README.md](../../../Patient/project_docs/standards/README.md)
* [README.md](../../../Patient/project_docs/value-objects/README.md)
* [README.md](../../../Cms/project_docs/blocks/README.md)
* [README.md](../../../Cms/project_docs/README.md)
* [README.md](../../../Cms/project_docs/standards/README.md)
* [README.md](../../../Cms/project_docs/content/README.md)
* [README.md](../../../Cms/project_docs/frontoffice/README.md)
* [README.md](../../../Cms/project_docs/components/README.md)
* [README.md](../../../../Themes/Two/project_docs/README.md)
* [README.md](../../../../Themes/One/project_docs/README.md)

## Regola sulle closure void nelle azioni custom Filament

### Motivazione
- Le closure dichiarate come `void` nelle azioni custom Filament devono solo eseguire effetti collaterali e **non restituire mai un valore**.
- Restituire un valore (anche implicito) genera errori a runtime e viola la policy DRY/KISS/zen.

### Esempio ERRATO
```php
->action(fn (Studio $record): void => $record->activate()) // ERRORE: activate() restituisce void, ma la closure lo "ritorna"
```

### Esempio CORRETTO
```php
->action(fn (Studio $record): void => $record->activate()) // CORRETTO: nessun return
// oppure
->action(function (Studio $record): void {
    $record->activate();
    // nessun return
})
```

### Policy
- Tutte le closure void devono solo eseguire effetti collaterali, mai return.
- Aggiornare la documentazione ogni volta che si corregge questo errore.

### Collegamento
- Vedi anche: [<nome progetto>/project_docs/filament-best-practices.mdc](../../../<nome progetto>/project_docs/filament-best-practices.mdc)

### Checklist
- [ ] Nessuna closure void restituisce un valore
- [ ] Tutte le azioni custom rispettano la signature void

# Regole generali per XotBaseResource

## Proprietà e metodi vietati nei Resource

Chi estende XotBaseResource **non deve mai** dichiarare o ridefinire:
- `protected static ?string $navigationIcon`
- `protected static ?string $navigationGroup`
- `protected static ?string $translationPrefix`
- `public static function table(...)`
- `public static function getListTableColumns(): array`

**Motivazione:**
- La logica di navigazione, traduzione e colonne è centralizzata per garantire coerenza e manutenibilità.
- Ridefinire queste proprietà/metodi nei resource porta a conflitti, duplicazione, errori di autoload e perdita di coerenza.
- Override solo tramite configurazione o metodi previsti, mai tramite ridefinizione diretta.

**Esempio corretto:**
```php
// ❌ NON FARE
protected static ?string $translationPrefix = 'doctor-resource';
$prefix = static::$translationPrefix;
->placeholder(__($prefix . '.first_name'))

// ✅ FARE
->placeholder(__('patient::doctor-resource.first_name'))
```

## Moduli che fanno riferimento a questa regola
- [Patient: DoctorResource](../../../Patient/project_docs/filament/resources/doctor-resource.md)
// Aggiungere qui altri moduli se necessario

