# Standard di Codice

Questa cartella contiene gli standard di codice e le convenzioni utilizzate nel progetto.

## File Contenuti

- `coding-standards.md` - Standard di codice generali
- `phpstan-rules.md` - Regole PHPStan specifiche
- `testing-standards.md` - Standard per i test

## Note

Questi standard si applicano a tutti i moduli del progetto e devono essere seguiti per mantenere la coerenza del codice.

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

# Standard Xot: Ereditarietà dei Modelli

## Gestione campi e Single Table Inheritance (STI)

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo (es. `certifications`), aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'certifications' in 'field list'`.

## Collegamenti
- [Modello Doctor (Patient)](../../../patient/project_docs/models/doctor.md)
- [Gestione campi e migrazioni con STI (README Patient)](../../../patient/project_docs/readme.md)
- [DoctorResource: Step Informazioni Personali (Patient)](../../../patient/project_docs/filament/resources/doctor-resource.md)
- [Struttura progetto e STI (Patient)](../../../patient/project_docs/architecture/struttura-progetto.md)
- [Migrazioni e database (Patient)](../../../patient/project_docs/database/migrations.md)

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
- [Patient: Modello Doctor](../../../patient/project_docs/models/doctor.md)
// Aggiungere qui altri moduli se necessario
