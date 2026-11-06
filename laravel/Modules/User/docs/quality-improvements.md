---
title: "Quality Improvements Summary - PHPStan, PHPMD, PHP Insights"
type: concept
tags: [quality, improvements]
created: 2026-07-14
updated: 2026-07-14
qmd: "quality-improvements quality improvements summary - phpstan, phpmd, php insights"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Quality Improvements Summary - PHPStan, PHPMD, PHP Insights

## Data: [DATE]

## Riepilogo Risultati

### PHPStan Level 10
**Status**: ✅ **COMPLETATO - 0 errori in tutti i moduli!**

- Modulo User: 0 errori (da ~221 iniziali)
- Tutti i moduli: 0 errori
- Conformità: 100% PHPStan Level 10

### PHPMD (PHP Mess Detector)
**Status**: ✅ **Warning principali risolti**

#### Problemi Risolti
1. **Collisione trait method `trans`** in `CreateSchedule.php` - RISOLTO
2. **Variabili inutilizzate** rimosse:
   - `$routename` in `RouteService.php`
   - `$items` in `RouteService.php`
   - `$appointment` in `XotBaseState.php`
   - `$check` in `HasModules.php`
   - `$path0` in `XotData.php`
   - `$result` in `EditUserWidget.php`

### PHP Insights
**Status**: ⚠️ **In miglioramento**

#### Punteggi Attuali
- **Code Quality**: 64.1% (target: 90%+)
- **Complexity**: 93.0% ✅ (target: 85%+)
- **Architecture**: 47.1% (target: 90%+)
- **Style**: 60.2% (target: 90%+)

#### Problemi Principali Identificati
1. **Ordered imports**: Molti file hanno import non ordinati (automatizzabile con PHP CS Fixer)
2. **Forbidden setters**: Alcuni servizi usano setter invece di constructor injection
3. **Naming conventions**: Alcuni file usano snake_case invece di camelCase
4. **Array indent**: Alcuni array non seguono lo stile corretto
5. **Language construct spacing**: Spazi mancanti in alcuni costrutti

## Correzioni Implementate

### 1. PHPStan - Return Types
- **ClientResource.php**: Corretto da `Component` a `Field`
- **EditUserWidget.php**: Aggiunto `@var array<string, mixed>` per `array_fill_keys()`

### 2. PHPMD - Variabili Inutilizzate
- Rimosse 6 variabili inutilizzate in vari file
- Migliorata leggibilità e manutenibilità del codice

### 3. PHP Insights - Prossimi Passi
- **Ordered imports**: Da automatizzare con PHP CS Fixer
- **Code quality**: Continuare rimozione variabili inutilizzate e setter
- **Architecture**: Analizzare coupling e migliorare design
- **Style**: Applicare naming conventions e formattazione corretta

## Note
- I file `.php-cs-fixer.*` causano errori di parsing in PHPMD (sono file di configurazione)
- I warning su `StaticAccess` per `Assert` sono accettabili (design pattern)
- Il catch vuoto in `XotBaseServiceProvider` è intenzionale (assets opzionali)

## Prossimi Passi
1. Automatizzare ordered imports con PHP CS Fixer
2. Continuare rimozione variabili inutilizzate
3. Analizzare e migliorare architecture score
4. Applicare style corrections sistematicamente
