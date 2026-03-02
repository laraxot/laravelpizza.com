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
* [README.md](bashscripts/project_docs/readme.md)
* [README.md](bashscripts/project_docs/it/readme.md)
* [README.md](docs/laravel-app/phpstan/readme.md)
* [README.md](docs/laravel-app/readme.md)
* [README.md](docs/moduli/struttura/readme.md)
* [README.md](docs/moduli/readme.md)
* [README.md](docs/moduli/manutenzione/readme.md)
* [README.md](docs/moduli/core/readme.md)
* [README.md](docs/moduli/installati/readme.md)
* [README.md](docs/moduli/comandi/readme.md)
* [README.md](docs/phpstan/readme.md)
* [README.md](docs/readme.md)
* [README.md](docs/module-links/readme.md)
* [README.md](docs/troubleshooting/git-conflicts/readme.md)
* [README.md](docs/tecnico/laraxot/readme.md)
* [README.md](docs/modules/readme.md)
* [README.md](docs/conventions/readme.md)
* [README.md](docs/amministrazione/backup/readme.md)
* [README.md](docs/amministrazione/monitoraggio/readme.md)
* [README.md](docs/amministrazione/deployment/readme.md)
* [README.md](docs/translations/readme.md)
* [README.md](docs/roadmap/readme.md)
* [README.md](docs/ide/cursor/readme.md)
* [README.md](docs/implementazione/api/readme.md)
* [README.md](docs/implementazione/testing/readme.md)
* [README.md](docs/implementazione/pazienti/readme.md)
* [README.md](docs/implementazione/ui/readme.md)
* [README.md](docs/implementazione/dental/readme.md)
* [README.md](docs/implementazione/core/readme.md)
* [README.md](docs/implementazione/reporting/readme.md)
* [README.md](docs/implementazione/isee/readme.md)
* [README.md](docs/it/readme.md)
* [README.md](laravel/vendor/mockery/mockery/project_docs/readme.md)
* [README.md](../../../chart/project_docs/readme.md)
* [README.md](../../../reporting/project_docs/readme.md)
* [README.md](../../../gdpr/project_docs/phpstan/readme.md)
* [README.md](../../../gdpr/project_docs/readme.md)
* [README.md](../../../notify/project_docs/phpstan/readme.md)
* [README.md](../../../notify/project_docs/readme.md)
* [README.md](../../../xot/project_docs/filament/readme.md)
* [README.md](../../../xot/project_docs/phpstan/readme.md)
* [README.md](../../../xot/project_docs/exceptions/readme.md)
* [README.md](../../../xot/project_docs/readme.md)
* [README.md](../../../xot/project_docs/standards/readme.md)
* [README.md](../../../xot/project_docs/conventions/readme.md)
* [README.md](../../../xot/project_docs/development/readme.md)
* [README.md](../../../dental/project_docs/readme.md)
* [README.md](../../../user/project_docs/phpstan/readme.md)
* [README.md](../../../user/project_docs/readme.md)
* [README.md](../../../user/project_docs/readme.md)
* [README.md](../../../ui/project_docs/phpstan/readme.md)
* [README.md](../../../ui/project_docs/readme.md)
* [README.md](../../../ui/project_docs/standards/readme.md)
* [README.md](../../../ui/project_docs/themes/readme.md)
* [README.md](../../../ui/project_docs/components/readme.md)
* [README.md](../../../lang/project_docs/phpstan/readme.md)
* [README.md](../../../lang/project_docs/readme.md)
* [README.md](../../../job/project_docs/phpstan/readme.md)
* [README.md](../../../job/project_docs/readme.md)
* [README.md](../../../media/project_docs/phpstan/readme.md)
* [README.md](../../../media/project_docs/readme.md)
* [README.md](../../../tenant/project_docs/phpstan/readme.md)
* [README.md](../../../tenant/project_docs/readme.md)
* [README.md](../../../activity/project_docs/phpstan/readme.md)
* [README.md](../../../activity/project_docs/readme.md)
* [README.md](../../../patient/project_docs/readme.md)
* [README.md](../../../patient/project_docs/standards/readme.md)
* [README.md](../../../patient/project_docs/value-objects/readme.md)
* [README.md](../../../cms/project_docs/blocks/readme.md)
* [README.md](../../../cms/project_docs/readme.md)
* [README.md](../../../cms/project_docs/standards/readme.md)
* [README.md](../../../cms/project_docs/content/readme.md)
* [README.md](../../../cms/project_docs/frontoffice/readme.md)
* [README.md](../../../cms/project_docs/components/readme.md)
* [README.md](../../../../themes/two/project_docs/readme.md)
* [README.md](../../../../themes/one/project_docs/readme.md)

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
- [Patient: DoctorResource](../../../patient/project_docs/filament/resources/doctor-resource.md)
// Aggiungere qui altri moduli se necessario
