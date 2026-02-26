# Standard di Codice

Questa cartella contiene gli standard di codice e le convenzioni utilizzate nel progetto.

## File Contenuti

- `coding-standards.md` - Standard di codice generali
- `phpstan-rules.md` - Regole PHPStan specifiche
- `testing-standards.md` - Standard per i test

## Note

Questi standard si applicano a tutti i moduli del progetto e devono essere seguiti per mantenere la coerenza del codice. 

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

# Standard Xot: Ereditarietà dei Modelli

## Gestione campi e Single Table Inheritance (STI)

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo (es. `certifications`), aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'certifications' in 'field list'`.

## Collegamenti
- [Modello Doctor (Patient)](../../../Patient/project_docs/Models/Doctor.md)
- [Gestione campi e migrazioni con STI (README Patient)](../../../Patient/project_docs/README.md)
- [DoctorResource: Step Informazioni Personali (Patient)](../../../Patient/project_docs/filament/resources/doctor-resource.md)
- [Struttura progetto e STI (Patient)](../../../Patient/project_docs/architecture/struttura-progetto.md)
- [Migrazioni e database (Patient)](../../../Patient/project_docs/database/migrations.md)

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
- [Patient: Modello Doctor](../../../Patient/project_docs/Models/Doctor.md)
// Aggiungere qui altri moduli se necessario

