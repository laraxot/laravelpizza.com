# Quality Tools Report - PHPStan, PHPMD, PHP Insights

## Data: 2025-01-02

## Riepilogo Risultati

### PHPStan Level 10
**Status**: ✅ **COMPLETATO - 0 errori in tutti i moduli!**

- Modulo User: 0 errori (da ~221 iniziali)
- Tutti i moduli: 0 errori
- Conformità: 100% PHPStan Level 10

#### Correzioni Finali
1. **ClientResource.php**: Corretto return type da `Component` a `Field` (classe base corretta per Filament 4)
   - Aggiunte chiavi stringhe all'array `getFormSchema()`
   - Corretto PHPDoc: `array<string, \Filament\Forms\Components\Field>`

### PHPMD (PHP Mess Detector)
**Status**: ⚠️ **1 warning risolto**

#### Problemi Risolti
1. **Collisione trait method `trans`** in `CreateSchedule.php`
   - **Causa**: `NavigationPageLabelTrait` già include `TransTrait`, ma `CreateSchedule` lo ridichiarava
   - **Soluzione**: Rimosso `use TransTrait;` da `CreateSchedule` (già incluso tramite `NavigationPageLabelTrait`)
   - **File**: `laravel/Modules/Job/app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php`

#### Note
- I file `.php-cs-fixer.*` causano errori di parsing in PHPMD (sono file di configurazione, non codice PHP)
- I warning su `StaticAccess` per `Assert` e `DB` sono accettabili (librerie di utilità progettate per uso statico)

### PHP Insights
**Status**: ⚠️ **Miglioramenti necessari**

#### Score Attuali
- **Code**: 64.1% (minimo richiesto: 90%)
- **Complexity**: 93.0% ✅ (minimo richiesto: 85%)
- **Architecture**: 47.1% (minimo richiesto: 90%)
- **Style**: 60.2% (minimo richiesto: 90%)

#### Problemi Principali Identificati

1. **Ordered Imports** (Stile)
   - Molti file hanno import non ordinati secondo PSR-12
   - **Soluzione**: Eseguire PHP CS Fixer per ordinare automaticamente gli import
   - **File interessati**: ~200+ file

2. **Forbidden Setters** (Code Quality)
   - Setter non permessi in:
     - `Xot/app/Models/Traits/HasExtraTrait.php:78`
     - `Xot/app/Services/ModuleService.php:50`
     - `Xot/app/Services/ThemeService.php:23`
   - **Soluzione**: Convertire a constructor injection o behavior naming

3. **Property Declaration** (Code Quality)
   - Proprietà con prefisso underscore (non conforme):
     - `Quaeris/app/Datas/LimeAnswerData.php:15` (`$_group_by`)
     - `Xot/app/Services/ModuleService.php:23` (`$_instance`)
     - `Xot/app/Traits/HasCsrfToken.php:15` (`$_token`)
   - **Soluzione**: Rimuovere prefisso underscore, usare visibilità appropriata

4. **Unused Variables** (Code Quality)
   - ~89 variabili non utilizzate
   - **Esempi**:
     - `Xot/app/Services/RouteService.php:79` (`$routename`)
     - `Xot/app/Services/RouteService.php:335` (`$items`)
     - `Xot/app/States/XotBaseState.php:78` (`$appointment`)
   - **Soluzione**: Rimuovere variabili non utilizzate

5. **Useless Variables** (Code Quality)
   - ~19 variabili inutili
   - **Esempi**:
     - `User/app/Filament/Widgets/EditUserWidget.php:113` (`$result`)
     - `User/app/Models/Traits/HasModules.php:27` (`$check`)
     - `Xot/app/Datas/XotData.php:356` (`$path0`)
   - **Soluzione**: Semplificare codice rimuovendo variabili intermedie non necessarie

6. **Array Indent** (Style)
   - Indentazione array non corretta in:
     - `Notify/app/Filament/Resources/MailTemplateResource.php:37,42,45`
   - **Soluzione**: Correggere indentazione secondo PSR-12

7. **Empty Statement** (Code Quality)
   - CATCH statement vuoto in:
     - `Xot/app/Providers/XotBaseServiceProvider.php:78`
   - **Soluzione**: Aggiungere logica o rimuovere catch se non necessario

8. **Naming Conventions** (Style)
   - Variabili/proprietà in snake_case invece di camelCase:
     - `$form_data`, `$old_value`, `$view_params`, `$queue_conn`, ecc.
   - **Soluzione**: Convertire a camelCase

9. **Static Access** (Design)
   - Molti accessi statici a Facades e classi utility
   - **Nota**: Alcuni sono accettabili (Facades Laravel, Assert), altri potrebbero essere migliorati con dependency injection

10. **Coupling Between Objects** (Architecture)
    - Alcune classi hanno coupling elevato (>13 dipendenze)
    - **Esempio**: `ScheduleResource.php` ha coupling di 20
    - **Soluzione**: Refactoring per ridurre dipendenze

## Strategia di Miglioramento

### Fase 1: Stile (Priorità Alta - Facile)
1. Eseguire PHP CS Fixer per ordinare import automaticamente
2. Correggere indentazione array
3. Correggere spacing language constructs

### Fase 2: Code Quality (Priorità Media)
1. Rimuovere variabili non utilizzate
2. Semplificare variabili inutili
3. Rimuovere/gestire empty catch statements
4. Convertire setter a constructor injection

### Fase 3: Naming (Priorità Media)
1. Convertire proprietà/variabili da snake_case a camelCase
2. Rimuovere prefissi underscore non necessari

### Fase 4: Architecture (Priorità Bassa - Complesso)
1. Analizzare classi con coupling elevato
2. Refactoring per ridurre dipendenze
3. Migliorare design patterns

## Comandi Utili

### PHP CS Fixer (Ordina Import)
```bash
cd laravel
./vendor/bin/php-cs-fixer fix Modules --rules=ordered_imports
```

### PHP Insights (Fix Automatici)
```bash
cd laravel
./vendor/bin/phpinsights fix Modules
```

### PHPMD (Escludere file config)
```bash
cd laravel
./vendor/bin/phpmd Modules text codesize,unusedcode,naming,design,controversial,cleancode --exclude "*.php-cs-fixer*.php"
```

## Conformità Laraxot

- ✅ PHPStan Level 10: 100% conforme
- ⚠️ PHPMD: 1 warning risolto, alcuni warning accettabili rimanenti
- ⚠️ PHP Insights: Miglioramenti necessari per raggiungere minimi richiesti

## Note

- I problemi di stile (ordered imports, indent) possono essere risolti automaticamente con PHP CS Fixer
- I problemi di code quality richiedono revisione manuale
- I problemi di architecture richiedono refactoring più approfondito
- La complessità ciclomatica è già ottima (93%)

## Collegamenti

- [PHPStan Complete Success](./phpstan-complete-success.md)
- [PHPStan Corrections Summary](./phpstan-corrections-summary-2025.md)
- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)

*Ultimo aggiornamento: 2025-01-02*
