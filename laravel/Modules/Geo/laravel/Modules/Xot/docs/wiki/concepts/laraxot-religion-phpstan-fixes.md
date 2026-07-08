# 🧘 Laraxot Religion: Guida per Fix PHPStan

> **Ogni fix deve rispettare la filosofia, religione, politica e zen di Laraxot**

## I 10 Comandamenti (Zero Tolerance)

### 1. **DRY - Non Ripetere**
```php
// ❌ SBAGLIATO: Duplicare metodi del trait in ogni modello
class Attachment extends Model {
    use SushiToJsons;
    
    public function getJsonFile(): string {  // MAI!
        return parent::getJsonFile();
    }
}

// ✅ CORRETTO: Usare il trait, metodi ereditati automaticamente
class Attachment extends Model {
    use SushiToJsons;
    // getJsonFile() ereditato dal trait
}
```

### 2. **XotBase* SEMPRE**
```php
// ❌ MAI estendere direttamente Filament/Laravel
class MyField extends Field           // ❌
class MyResource extends Resource     // ❌
class MyWidget extends Widget         // ❌

// ✅ SEMPRE estendere XotBase
class MyField extends XotBaseField              // ✅
class MyResource extends XotBaseResource        // ✅
class MyWidget extends XotBaseWidget              // ✅
class MyWizard extends XotBaseWizardWidget        // ✅
```

### 3. **No Inline Translations**
```php
// ❌ FORBIDDEN - Zero Tolerance
->label('My Label')
->placeholder('Enter...')
->helperText('Help...')
->tooltip('Tip...')
->hint('Hint...')

// ✅ AUTOMATIC via LangServiceProvider
// Le traduzioni vengono risolte automaticamente da:
// namespace::context.collection.element.type
```

### 4. **Safe Functions**
```php
// ❌ Non usare funzioni PHP native direttamente
file_get_contents($path);   // Può ritornare false
json_encode($data);           // Può ritornare false

// ✅ Usare Safe\ functions
\Safe\file_get_contents($path);
\Safe\json_encode($data);
```

### 5. **Module ≠ Theme**
```php
// ❌ SBAGLIATO: Modulo che decide la view
class TicketForm {
    public function getFormSchema() {
        return inAdmin() 
            ? Wizard::make() 
            : PubThemeWizard::make();  // ❌ Modulo non deve sapere del tema
    }
}

// ✅ CORRETTO: Modulo crea componenti standard
class TicketForm {
    public function getFormSchema() {
        return [Wizard::make()];  // ✅ Standard sempre
    }
}
// Il tema gestisce la presentazione via CSS/Blade wrapper
```

### 6. **No $view in Wizard Subclasses**
```php
// ❌ FORBIDDEN
class MyWizard extends XotBaseWizardWidget {
    protected string $view = 'my-view';  // MAI!
}

// ✅ CORRETTO: View calcolata automaticamente
class MyWizard extends XotBaseWizardWidget {
    // NO $view property
    // Admin: filament/components/wizard
    // Frontoffice: pub_theme::components.wizard
}
```

### 7. **Classes, Not IDs (Leaflet)**
```javascript
// ❌ MAI usare ID per mappe
<div id="map"></div>
document.getElementById('map');

// ✅ SEMPRE usare classi
<div class="map-container"></div>
this.querySelector('.map-container');
```

### 8. **PHPStan: No Ignoring**
```php
// ❌ NON ignorare errori PHPStan
// phpstan.neon:
// ignoreErrors:
//     - '#Class not found#'  // MAI!

// ✅ Correggere la root cause
// - Aggiungere use statement
// - Installare package mancante
// - Correggere namespace
```

### 9. **Single Source of Truth**
```php
// ❌ Duplicazione config/transazioni
const PI = 3.14;  // In ogni file?

// ✅ Un solo posto
// config/constants.php
// Lang files per traduzioni
```

### 10. **Type Safety Strict**
```php
// ❌ No type hints
function process($data) { }

// ✅ Strict typing
declare(strict_types=1);

function process(array $data): ProcessedData { }
```

## Tipologie di Errori PHPStan & Fix Corretti

### Class Not Found
**Causa**: Namespace errato, classe non esiste, o package non installato.

**Fix Philosophy**:
1. Verificare se la classe è realmente necessaria
2. Se sì: correggere namespace o installare package
3. Se no: rimuovere l'uso o marcare come deprecated

```php
// Esempio: Spatie\ModelStates\State
// Opzione 1: Installare package
composer require spatie/laravel-model-states

// Opzione 2: Aggiungere stub per PHPStan
// phpstan.neon (SOLO se package non può essere installato)
// Ma preferibile correggere

// Opzione 3: PHPDoc per type hinting
/** @var \Spatie\ModelStates\State $state */
```

### Method Not Found
**Causa**: Metodo chiamato su tipo sbagliato o metodo non esiste.

**Fix Philosophy**:
1. Aggiungere @property/@method in PHPDoc
2. Oppure usare trait corretto
3. Oppure verificare tipo di ritorno

```php
// Esempio: Call to undefined method Model::getAddress()

// Opzione 1: PHPDoc per dire a PHPStan
/**
 * @method string getAddress()
 */
class MyModel extends Model {
    // ...
}

// Opzione 2: Type checking runtime
if (method_exists($model, 'getAddress')) {
    $address = $model->getAddress();
}
```

### Type Mismatch
**Causa**: Tipo atteso vs tipo ricevuto diverso.

**Fix Philosophy**:
1. Aggiungere type hints
2. Usare casting esplicito
3. Verificare flusso dati

```php
// Esempio: expects string, int given
function process(string $name): void { }

// Fix:
process((string) $userId);  // Casting esplicito
```

## Checklist Pre-Fix

Prima di ogni correzione:

- [ ] Ho compreso la root cause?
- [ ] Il fix rispetta DRY?
- [ ] Sto usando XotBase* classes?
- [ ] Non sto duplicando logica esistente?
- [ ] Ho verificato Safe\ functions?
- [ ] Ho aggiornato la documentazione?
- [ ] Ho ingested in QMD?

## Documentazione Post-Fix

Ogni fix deve includere:

```php
/**
 * Fix: [Descrizione breve]
 * 
 * Root Cause: [Perché PHPStan segnalava errore]
 * Solution: [Come ho risolto]
 * Philosophy: [Quale regola Laraxot applica]
 * 
 * @see laravel/Modules/Xot/docs/wiki/concepts/laraxot-religion-phpstan-fixes.md
 * @since 2026-05-05
 */
```

## Related

- [[../architecture/laraxot-philosophy]] - Filosofia completa
- [[../../../../../docs/ZEN_OF_FIXCITY.md]] - Zen di FixCity
- [[./phpstan-fix-patterns]] - Pattern specifici per fix

---

**Remember: Zero tolerance per shortcut. Ogni fix deve essere "The Right Way™"**
