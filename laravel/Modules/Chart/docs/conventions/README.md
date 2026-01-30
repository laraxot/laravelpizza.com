# Convenzioni di Naming in il progetto

## Panoramica
Questo documento definisce le convenzioni standard per il naming nel progetto il progetto, coprendo database, modelli, directory e file. Seguire queste convenzioni è fondamentale per mantenere coerenza, facilitare l'internazionalizzazione e garantire compatibilità.

## Struttura delle Directory

### Directory Standard
- `resources` (minuscolo) per viste/assets/lang
- `views` per i template Blade
- `components` per i componenti Blade
- `lang` per le traduzioni
- `css` per gli stili
- `js` per gli script

### Best Practices per Directory
1. **Naming**:
   - Usare sempre lettere minuscole
   - Usare underscore per gli spazi
   - Seguire le convenzioni di Laravel

2. **Struttura**:
   ```
   resources/
   ├── views/
   │   ├── components/
   │   │   ├── section.blade.php
   │   │   └── ...
   │   └── ...
   ```

## Campi Database e Modelli

### Campi Utente e Persona
Regola Fondamentale: seguire sempre la convenzione inglese

✅ CORRETTO:
- `first_name` (mai `name`)
- `last_name` (mai `surname`)

❌ ERRATO:
- `name`
- `surname`

### Motivazione
1. **Internazionalizzazione**: Facilita l'internazionalizzazione mantenendo coerenza
2. **Compatibilità API**: Garantisce compatibilità con servizi esterni
3. **Coerenza Database**: Mantiene una struttura uniforme
4. **Standard PSR**: Allineamento con convenzioni PHP moderne

### Implementazione

#### Nelle Migrazioni
```php
// ✅ CORRETTO
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
});

// ❌ ERRATO
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('surname');
});
```

#### Nei Modelli
```php
// ✅ CORRETTO
protected $fillable = [
    'first_name',
    'last_name',
    'email',
];

// ❌ ERRATO
protected $fillable = [
    'name',
    'surname',
    'email',
];
```

### Altri Campi Standard

1. **Campi Temporali**:
   - ✅ `created_at`, `updated_at`, `deleted_at`
   - ✅ `birth_date` (mai `date_of_birth`)
   - ✅ `start_time`, `end_time`

2. **Campi di Stato**:
   - ✅ `status` (mai `state`)
   - ✅ `is_active`, `is_verified`

3. **Chiavi Esterne**:
   - ✅ `user_id`, `patient_id` (mai `id_user`)

4. **Campi di Contatto**:
   - ✅ `email` (mai `mail`)
   - ✅ `phone` (mai `telephone`)
   - ✅ `address` (mai `location`)

## Convenzioni per Moduli

### Modulo Xot
- Classi base: `XotBase{Type}`
- Namespace: `Modules\Xot\Filament\Pages`
- Implementazioni: nei rispettivi moduli

### Best Practices
1. **Coerenza**:
   - Seguire i pattern stabiliti
   - Documentare le eccezioni
   - Mantenere namespace corretti

2. **Chiarezza**:
   - Nomi descrittivi
   - Prefissi appropriati
   - Suffissi significativi

## Verifica e Correzione

### Verifica
```bash
php artisan xot:analyze-naming
```

### Correzione
Per rinominare campi non conformi:
```php
Schema::table('users', function (Blueprint $table) {
    $table->renameColumn('name', 'first_name');
    $table->renameColumn('surname', 'last_name');
});
```

## Collegamenti Bidirezionali

### Documentazione Moduli
- [Struttura Moduli](../struttura-moduli.md)
- [Architettura Folio+Volt](../architettura-folio-volt.md)
- [Modulo Xot - Struttura](../../laravel/Modules/Xot/docs/MODULE_STRUCTURE.md)
- [Regole Traduzioni](../../laravel/Modules/Xot/docs/TRANSLATIONS.md)

### Documentazione Esterna
- [Documentazione Componenti CMS](../../laravel/Modules/Cms/docs/components/README.md)
- [Documentazione Laravel Ufficiale](https://laravel.com/docs) 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
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
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

