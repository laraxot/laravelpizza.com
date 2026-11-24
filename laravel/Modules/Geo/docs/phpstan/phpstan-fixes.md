---
title: "phpstan fixes"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan fixes"
issues: []
discussions: []
---

# Correzioni PHPStan Modulo Geo - 2025-01-27

**Data**: 2025-01-27  
**Versione PHPStan**: 1.12.x  
**Livello**: 10  
**Status**: ✅ COMPLETATO  

## 🔧 Correzioni Implementate

### 1. WebbingbrasilMap Widget - Errore Proprietà Statica

**Problema**: 
```
Cannot redeclare non static Filament\Widgets\Widget::$view as static Modules\Geo\Filament\Widgets\WebbingbrasilMap::$view
```

**Causa**: La proprietà `$view` era definita come `static` nella classe derivata mentre nella classe base `Widget` è non-statica.

**Soluzione**: 
1. Rinominato file originale come `.disabled4` per mantenere traccia storica
2. Creato nuovo file stub che estende direttamente `Widget` invece di `XotBaseWidget`
3. Corretto la proprietà `$view` da `protected static string` a `protected string`
4. Mantenuto il metodo `canView()` che restituisce `false` per disabilitazione temporanea

**File Modificato**: 
- `Modules/Geo/app/Filament/Widgets/WebbingbrasilMap.php`

**Codice Prima**:
```php
class WebbingbrasilMap extends XotBaseWidget
{
    protected static string $view = 'geo::filament.widgets.webbingbrasil-map-stub';
    // ...
}
```

**Codice Dopo**:
```php
class WebbingbrasilMap extends Widget
{
    protected string $view = 'geo::filament.widgets.webbingbrasil-map-stub';
    
    public static function canView(): bool
    {
        return false; // Temporaneamente disabilitato per Filament v4
    }
}
```

## 📋 Dettagli Tecnici

### Motivazione della Correzione
- **Compatibilità Filament v4**: Il widget è temporaneamente disabilitato per problemi di compatibilità
- **Conformità PHPStan**: Risolve errore di ridichiarazione di proprietà con visibilità diversa
- **Architettura Pulita**: Estende direttamente `Widget` per semplicità dato che è un stub

### Vista Stub Utilizzata
Il widget utilizza la vista `geo::filament.widgets.webbingbrasil-map-stub` che mostra:
- Messaggio di mappa non disponibile
- Icona placeholder
- Spiegazione della disabilitazione temporanea

## 🔗 Contesto Architetturale

### Integrazione con Filament 4.x
Il widget fa parte del piano di migrazione a Filament 4.x documentato in:
- `filament_4x_compatibility.md`
- Piano di riattivazione graduale quando i pacchetti saranno compatibili

### Pacchetti Coinvolti
- `webbingbrasil/filament-maps` - Non compatibile con Filament 4.x
- Widget disabilitato fino a rilascio versione compatibile

## ✅ Risultato
- ✅ Errore PHPStan risolto
- ✅ Widget funziona come stub (mostra messaggio disabilitazione)
- ✅ Compatibilità Filament 4.x mantenuta
- ✅ Tracciabilità storica preservata (file .disabled4)

## 🔄 Prossimi Passi

1. **Monitoraggio**: Verificare rilasci di `webbingbrasil/filament-maps` compatibili con Filament 4.x
2. **Riattivazione**: Quando disponibile, riattivare widget con nuova implementazione
3. **Testing**: Test completi di integrazione post-riattivazione

## 📚 Collegamenti

- [Documentazione Compatibilità Filament 4.x](./filament_4x_compatibility.md)
- [Documentazione Widget Disabilitati](./widgets/disabled_widgets.md)
- [Piano Migrazione Filament](../../../docs/filament_4x_migration_plan.md)

---

title: "phpstan fixes"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan fixes"
issues: []
discussions: []
# PHPStan Zero Errors Achievement - 2026-06-13

**Data**: 2026-06-13  
**PHPStan Level**: max  
**Status**: ✅ ZERO ERRORS  

## 🎯 Correzioni PHPStan Modules Analysis

### 1. Dead Catch Block Resolution

**Problema**:
```
Dead catch - InvalidArgumentException is never thrown in the try block
```

**File**: `tests/Unit/Actions/GoogleMaps/GetCoordinatesFromGoogleMapsActionTest.pest.php`

**Causa**: La funzione `GetCoordinatesFromGoogleMapsAction` usa `Webmozart\Assert\Assert` che lancia `InvalidArgumentException`, ma i docstring non lo documentavano.

**Soluzione**:
1. Aggiunto `@throws \InvalidArgumentException` ai docstring di:
   - `validateInput()` — valida input
   - `execute()` — metodo pubblico

**File Modificato**:
- `app/Actions/GoogleMaps/GetCoordinatesFromGoogleMapsAction.php`

```php
/**
 * Valida i dati di input.
 * @throws \InvalidArgumentException Se i dati non sono validi
 */
private function validateInput(string $address): void

/**
 * Ottiene le coordinate da un indirizzo.
 * @throws \InvalidArgumentException Se i dati non sono validi
 * @throws \RuntimeException Se la chiave API non è configurata o la richiesta fallisce
 */
public function execute(string $address): LocationData
```

### 2. Pest Class Resolution Fix

**Problema**:
```
The class `Modules\Geo\Tests\Unit\Actions\GoogleMaps\LightTestCase` was not found
```

**Causa**: Pest risolve i class name relative al namespace del file test

**Soluzione**: Usare fully qualified class name in `uses()`:

```php
// Prima (errato)
uses(LightTestCase::class);

// Dopo (corretto)
uses(\Modules\Geo\Tests\LightTestCase::class);
```

**File Modificati**:
- `tests/Unit/Actions/GoogleMaps/CalculateTravelTimeActionTest.pest.php`
- `tests/Unit/Actions/GoogleMaps/GetCoordinatesFromGoogleMapsActionTest.pest.php`

## 📚 Key Learning: Webmozart Assert

La libreria `Webmozart\Assert\Assert` lancia `InvalidArgumentException` per validazioni:

```php
Assert::notEmpty($apiKey, '...');     // → InvalidArgumentException
Assert::maxLength($address, 1000, '...'); // → InvalidArgumentException
```

Sempre documentare in docstring: `@throws \InvalidArgumentException`

## ✅ Validazione

```bash
./vendor/bin/phpstan analyse Modules/Geo
# Result: [OK] No errors
```

## 🔗 Related Rules

- [Webmozart Assert Exception Types](../../../docs/wiki/rules/webmozart-assert-exceptions.md)
- [Pest Fully Qualified Class Names](../../../docs/wiki/skills/pest-fqn-resolution.md)

*Ultimo aggiornamento: 2026-06-13*
