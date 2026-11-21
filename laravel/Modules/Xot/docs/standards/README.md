---
title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
---

# Standard di Codice

Questa cartella contiene gli standard di codice e le convenzioni utilizzate nel progetto.

## File Contenuti

- `coding-standards.md` - Standard di codice generali
- `phpstan-rules.md` - Regole PHPStan specifiche
- `testing-standards.md` - Standard per i test

## Note

Questi standard si applicano a tutti i moduli del progetto e devono essere seguiti per mantenere la coerenza del codice.

## Collegamenti tra versioni di README.md
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
* [README.md](../../../Chart/docs/README.md)
* [README.md](../../../reporting/docs/README.md)
* [README.md](../../../gdpr/docs/phpstan/README.md)
* [README.md](../../../Gdpr/docs/README.md)
* [README.md](../../../notify/docs/phpstan/README.md)
* [README.md](../../../Notify/docs/README.md)
* [README.md](../../../xot/docs/filament/README.md)
* [README.md](../../../xot/docs/phpstan/README.md)
* [README.md](../../../xot/docs/exceptions/README.md)
* [README.md](../README.md)
* [README.md](readme.md)
* [README.md](../../../xot/docs/conventions/README.md)
* [README.md](../../../xot/docs/development/README.md)
* [README.md](../../../dental/docs/README.md)
* [README.md](../../../user/docs/phpstan/README.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../ui/docs/phpstan/README.md)
* [README.md](../../../UI/docs/README.md)
* [README.md](../../../UI/docs/standards/README.md)
* [README.md](../../../ui/docs/themes/README.md)
* [README.md](../../../ui/docs/components/README.md)
* [README.md](../../../lang/docs/phpstan/README.md)
* [README.md](../../../Lang/docs/README.md)
* [README.md](../../../job/docs/phpstan/README.md)
* [README.md](../../../Job/docs/README.md)
* [README.md](../../../media/docs/phpstan/README.md)
* [README.md](../../../Media/docs/README.md)
* [README.md](../../../tenant/docs/phpstan/README.md)
* [README.md](../../../Tenant/docs/README.md)
* [README.md](../../../activity/docs/phpstan/README.md)
* [README.md](../../../Activity/docs/README.md)
* [README.md](../../../patient/docs/README.md)
* [README.md](../../../patient/docs/standards/README.md)
* [README.md](../../../patient/docs/value-objects/README.md)
* [README.md](../../../Cms/docs/blocks/README.md)
* [README.md](../../../Cms/docs/README.md)
* [README.md](../../../Cms/docs/standards/README.md)
* [README.md](../../../Cms/docs/content/README.md)
* [README.md](../../../Cms/docs/frontoffice/README.md)
* [README.md](../../../Cms/docs/components/README.md)
* [README.md](../../../../themes/two/docs/README.md)
* [README.md](../../../../themes/one/docs/README.md)

# Standard Xot: Ereditarietà dei Modelli

## Gestione campi e Single Table Inheritance (STI)

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo (es. `certifications`), aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'certifications' in 'field list'`.

## Collegamenti
- [Modello Doctor (Patient)](../../../patient/docs/models/doctor.md)
- [Gestione campi e migrazioni con STI (README Patient)](../../../patient/docs/README.md)
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
