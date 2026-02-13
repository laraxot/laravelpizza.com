# PHPStan Patterns - Dicembre 2025

## 🎯 Nuovi Pattern Scoperti

### 1. PHPDoc Tag Anti-Pattern
**Problema**: PHPDoc tag che tentano di sovrascrivere tipi nativi

```php
// ❌ ANTI-PATTERN
/** @var view-string $view */
return view($view);

// ✅ PATTERN CORRETTO
return view((string) $view);
```

**Spiegazione**: I PHPDoc tag non dovrebbero essere usati per forzare tipi quando PHP può inferirli o quando un cast esplicito è più appropriato.

### 2. Type Safety con Assert prima di costruttori
**Pattern**: Validare tipi prima di passare a costruttori strict

```php
// ✅ PATTERN
$out = View::make($view, $data);
$html = $out->render();
Assert::string($html);
return new HtmlString($html);
```

**Spiegazione**: Usare Assert di Webmozart per garantire type safety prima di creare oggetti con tipi strict.

### 3. Import Verification Pattern
**Problema**: Import di classi che non esistono o uso errato di facade

```php
// ❌ ERRORE
use Illuminate\Support\Facades\View as ViewFactory;

// ✅ CORRETTO
use Illuminate\Support\Facades\View;
```

**Spiegazione**: Verificare sempre che le classi importate esistano e usare il nome corretto delle facade.

## 🔧 Pattern Consolidati

### 1. SafeStringCastAction per Cast Sicuri
```php
$title = SafeStringCastAction::cast($attachment->title);
$description = SafeStringCastAction::cast($attachment->description);
```

### 2. hasAttribute() invece di property_exists()
```php
// ❌ SU MODELLI ELOQUENT
if (property_exists($model, 'attribute')) { }

// ✅ CORRETTO
if ($model->hasAttribute('attribute')) { }
```

### 3. Type Narrowing Esplicito
```php
$causerId = null;
if ($this->user !== null) {
    if (! $this->user instanceof User) {
        throw new \InvalidArgumentException('User must be an instance of User');
    }
    $id = $this->user->getAttribute('id');
    $causerId = is_int($id) || is_string($id) ? $id : null;
}
```

## 📚 Regole d'Oro

1. **Nessun compromesso sulla type safety**
2. **PHPDocs solo quando necessari**
3. **Assert per validazioni critiche**
4. **Cast espliciti quando PHPStan non inferisce**
5. **Sempre usare classi XotBase per Filament**

## 🚀 Da Evitare

- `property_exists()` su modelli Eloquent
- PHPDoc tag ridondanti
- Mixed types non gestiti
- Estensione diretta di classi Filament
- `->label()` su componenti Filament

## ✅ Best Practices

- Safe cast actions
- Type narrowing
- hasAttribute() per modelli
- XotBase extension
- File di traduzione per label

## 🎉 Risultati

Applicando questi pattern, abbiamo raggiunto:
- **0 errori PHPStan** in tutti i moduli
- **Type safety al livello massimo**
- **Codice manutenibile e robusto**