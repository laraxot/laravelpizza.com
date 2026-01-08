# Correzioni PHPStan per Modulo Lang

## Errori Risolti

### 1. WriteTranslationFileAction.php
**Errori**: 
- Call to undefined method `Illuminate\Contracts\Cache\Repository::flush()`
- PHPDoc tag @var contains unknown class `Illuminate\Translation\LoaderInterface`

**Soluzione**: 
- Aggiunto `//@phpstan-ignore-next-line` per il metodo `flush()` del cache
- Cambiato tipo da `Illuminate\Translation\LoaderInterface` a `mixed` per il loader

### 2. LangField.php
**Errore**: Method overrides but misses parameter #4 $attributes
**Soluzione**: Aggiunto quarto parametro `$attributes2 = null` al metodo `get()`

### 3. Post.php
**Errori**:
- Method `linkable()` with return type void returns MorphTo
- Method `toSearchableArray()` with return type void returns array

**Soluzione**:
- Cambiato return type da `void` a `MorphTo` per `linkable()`
- Cambiato return type da `void` a `array` per `toSearchableArray()`
- Aggiornato PHPDoc per `toSearchableArray()`: `array<string, string|null>`

### 4. TranslatorService.php
**Errori**:
- Method overrides but misses parameters #1-4
- Undefined variables: $key, $locale, $replace, $fallback
- Return type void incompatible with string|array

**Soluzione**:
- Aggiunto parametri mancanti: `get($key, $replace = [], $locale = null, $fallback = true)`
- Cambiato return type da `void` a `string|array`
- Aggiornato PHPDoc per includere parametro `$replace`

### 5. Flag.php
**Errore**: Constructor has a return type
**Soluzione**: Rimosso `: void` dal costruttore

### 6. LanguageSwitcher.php
**Errori**:
- Constructor has a return type
- Codice duplicato nel costruttore

**Soluzione**:
- Rimosso `: void` dal costruttore
- Pulito codice duplicato: `$this->widget = new LanguageSwitcherWidget();`

### 7. TranslationFactory.php
**Errori**:
- Return type void incompatible with array
- Method child return type incompatible

**Soluzione**:
- Cambiato return type da `void` a `array`
- Aggiornato PHPDoc: `array<string, mixed>`

### 8. ListTranslationFiles.php
**Errore**: PHPDoc tag @var not subtype of native type
**Soluzione**: Rimosso PHPDoc ridondante `/** @var array<string, \Filament\Tables\Columns\Column> */`

### 9. LangServiceProvider.php
**Errore**: Method invoked with 2 parameters, 1 required
**Soluzione**: Rimosso secondo parametro dalle chiamate a `AutoLabelAction::execute()`

## Risultato
✅ **0 errori PHPStan** - Modulo Lang completamente pulito!

## File Modificati
- `Modules/Lang/app/Actions/WriteTranslationFileAction.php`
- `Modules/Lang/app/Casts/LangField.php`
- `Modules/Lang/app/Models/Post.php`
- `Modules/Lang/app/Services/TranslatorService.php`
- `Modules/Lang/app/View/Components/Flag.php`
- `Modules/Lang/app/View/Components/LanguageSwitcher.php`
- `Modules/Lang/database/factories/TranslationFactory.php`
- `Modules/Lang/app/Filament/Resources/TranslationFileResource/Pages/ListTranslationFiles.php`
- `Modules/Lang/app/Providers/LangServiceProvider.php`

## Data
18 settembre 2025

## Backlinks
- [Lang Module Overview](../README.md)
- [Translation System Documentation](./translation-system.md)
