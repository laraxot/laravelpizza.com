# Standard di Codice

Questa cartella contiene gli standard di codice e le convenzioni utilizzate nel progetto.

## File Contenuti

- `coding-standards.md` - Standard di codice generali
- `phpstan-rules.md` - Regole PHPStan specifiche
- `testing-standards.md` - Standard per i test

## Note

Questi standard si applicano a tutti i moduli del progetto e devono essere seguiti per mantenere la coerenza del codice.

## Collegamenti tra versioni di README.md
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
* [README.md](laravel/vendor/mockery/mockery/docs/readme.md)
* [README.md](../../../chart/docs/readme.md)
* [README.md](../../../reporting/docs/readme.md)
* [README.md](../../../gdpr/docs/phpstan/readme.md)
* [README.md](../../../gdpr/docs/readme.md)
* [README.md](../../../notify/docs/phpstan/readme.md)
* [README.md](../../../notify/docs/readme.md)
* [README.md](../../../xot/docs/filament/readme.md)
* [README.md](../../../xot/docs/phpstan/readme.md)
* [README.md](../../../xot/docs/exceptions/readme.md)
* [README.md](../../../xot/docs/readme.md)
* [README.md](../../../xot/docs/standards/readme.md)
* [README.md](../../../xot/docs/conventions/readme.md)
* [README.md](../../../xot/docs/development/readme.md)
* [README.md](../../../dental/docs/readme.md)
* [README.md](../../../user/docs/phpstan/readme.md)
* [README.md](../../../user/docs/readme.md)
* [README.md](../../../user/docs/readme.md)
* [README.md](../../../ui/docs/phpstan/readme.md)
* [README.md](../../../ui/docs/readme.md)
* [README.md](../../../ui/docs/standards/readme.md)
* [README.md](../../../ui/docs/themes/readme.md)
* [README.md](../../../ui/docs/components/readme.md)
* [README.md](../../../lang/docs/phpstan/readme.md)
* [README.md](../../../lang/docs/readme.md)
* [README.md](../../../job/docs/phpstan/readme.md)
* [README.md](../../../job/docs/readme.md)
* [README.md](../../../media/docs/phpstan/readme.md)
* [README.md](../../../media/docs/readme.md)
* [README.md](../../../tenant/docs/phpstan/readme.md)
* [README.md](../../../tenant/docs/readme.md)
* [README.md](../../../activity/docs/phpstan/readme.md)
* [README.md](../../../activity/docs/readme.md)
* [README.md](../../../patient/docs/readme.md)
* [README.md](../../../patient/docs/standards/readme.md)
* [README.md](../../../patient/docs/value-objects/readme.md)
* [README.md](../../../cms/docs/blocks/readme.md)
* [README.md](../../../cms/docs/readme.md)
* [README.md](../../../cms/docs/standards/readme.md)
* [README.md](../../../cms/docs/content/readme.md)
* [README.md](../../../cms/docs/frontoffice/readme.md)
* [README.md](../../../cms/docs/components/readme.md)
* [README.md](../../../../themes/two/docs/readme.md)
* [README.md](../../../../themes/one/docs/readme.md)

# Standard Xot: Ereditarietà dei Modelli

## Gestione campi e Single Table Inheritance (STI)

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo (es. `certifications`), aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'certifications' in 'field list'`.

## Collegamenti
- [Modello Doctor (Patient)](../../../patient/docs/models/doctor.md)
- [Gestione campi e migrazioni con STI (README Patient)](../../../patient/docs/readme.md)
- [DoctorResource: Step Informazioni Personali (Patient)](../../../patient/docs/filament/resources/doctor-resource.md)
- [Struttura progetto e STI (Patient)](../../../patient/docs/architecture/struttura-progetto.md)
- [Migrazioni e database (Patient)](../../../patient/docs/database/migrations.md)

## Regola generale

- I modelli specializzati (es. Doctor, Patient, ecc.) **devono** estendere il modello User del proprio modulo, **mai** Model o BaseModel direttamente.
- Devono usare sempre il trait `\Parental\HasParent` per il corretto funzionamento dello STI (Single Table Inheritance) con tighten/parental.
- Tutta la logica comune va nel modello User, mentre i modelli specializzati contengono solo le specificità.

**Esempio corretto:**
```php
namespace Modules\Patient\Models;

use Parental\HasParent;

class Doctor extends User
{
    use HasParent;
    // ...
}
```

## Moduli che applicano questa regola
// Aggiungere qui altri moduli se necessario
