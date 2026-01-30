# Sistema di Traduzioni in il progetto

## Indice e Collegamenti

> **Nota**: Questo documento è un indice che punta alla documentazione dettagliata nei moduli specifici.

## Documentazione Principale

### Modulo Lang (Gestione Centralizzata)

- [Regole per le Traduzioni in Filament](../../laravel/Modules/Lang/docs/filament-translations.md) - **IMPORTANTE**: Regola fondamentale sul divieto di usare `->label()`
- [Introduzione alle Traduzioni](../../laravel/Modules/Lang/docs/introduction.md) - Concetti base e architettura
- [Struttura delle Traduzioni](../../laravel/Modules/Lang/docs/structure.md) - Organizzazione dei file di traduzione
- [Gestione dei File di Lingua](../../laravel/Modules/Lang/docs/module_lang.md) - Come gestire i file di lingua nei moduli

### Modulo Cms (Implementazione Frontend)

- [Convenzioni Namespace Filament](../../laravel/Modules/Cms/docs/convenzioni-namespace-filament.md) - Include regole sulle traduzioni nei componenti Filament
- [Collegamento alle Traduzioni](../../laravel/Modules/Cms/docs/lang-link.md) - Integrazione tra Cms e Lang per le traduzioni

### Altri Moduli

- [Regole Generali (Xot)](../../laravel/Modules/Xot/docs/translations.md)
- [Modulo Patient](../../laravel/Modules/Patient/docs/translations.md)

## Principi Fondamentali

1. **Regole Chiave**:
   - **MAI utilizzare `->label()`** nei componenti Filament
   - Utilizzare i file di traduzione del modulo in `Modules/<NomeModulo>/lang/<lingua>`
   - Il `LangServiceProvider` gestisce automaticamente le etichette
   - Seguire la convenzione di naming: `modulo::risorsa.fields.campo.label`

2. **Struttura**:
   - Regole generali nel modulo Xot
   - Implementazioni specifiche nei moduli
   - Collegamenti bidirezionali tra moduli

3. **Best Practices**:
   - Aggiornare la documentazione del modulo
   - Mantenere i collegamenti aggiornati
   - Verificare la coerenza delle traduzioni

## Collegamenti Bidirezionali

- [Documentazione Lang-Cms](../../laravel/Modules/Lang/docs/cms-link.md) - Collegamento dal modulo Lang al modulo Cms
- [Documentazione Cms-Lang](../../laravel/Modules/Cms/docs/lang-link.md) - Collegamento dal modulo Cms al modulo Lang

## Manutenzione

1. **Aggiornamento Traduzioni**:
   - Aggiungere nuove traduzioni nel modulo appropriato
   - Mantenere la coerenza con le convenzioni di naming
   - Verificare i collegamenti bidirezionali

2. **Verifica Qualità**:
   - Controllare la completezza delle traduzioni
   - Verificare la correttezza dei collegamenti
   - Aggiornare la documentazione quando necessario 
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

