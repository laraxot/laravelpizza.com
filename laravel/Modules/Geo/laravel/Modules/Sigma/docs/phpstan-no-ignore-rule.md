# Regola Fondamentale: MAI Ignorare Errori PHPStan

## 🚨 PRINCIPIO ASSOLUTO

**GLI ERRORI PHPSTAN NON VANNO MAI IGNORATI - VANNO SEMPRE RISOLTI**

Questa è una regola **NON DEROGABILE** che deve essere sempre ricordata e applicata.

## ❌ MAI FARE QUESTO

```php
// ❌ ERRATO - MAI IGNORARE ERRORI
// @phpstan-ignore-next-line
$instance = new self();

// @phpstan-ignore-next-line
$value = $mixed->property;
```

## ✅ SEMPRE FARE QUESTO

```php
// ✅ CORRETTO - RISOLVERE L'ERRORE
$instance = self::getConcreteInstance(); // Usa metodo helper esistente

// ✅ CORRETTO - TIPIZZARE CORRETTAMENTE
/** @var ConcreteClass $value */
$value = $mixed;
$property = $value->property;
```

## 📋 Processo Corretto per Risolvere Errori

1. **Analizzare l'errore**: Capire la causa root dell'errore PHPStan
2. **Studiare la documentazione**: Consultare docs dei moduli, Laravel docs, PHPStan docs
3. **Cercare pattern esistenti**: Verificare se esistono già soluzioni nel codebase
4. **Implementare soluzione corretta**: Tipizzare, aggiungere controlli, usare helper methods
5. **Documentare la soluzione**: Aggiornare docs con pattern e motivazione

## 🎯 Esempi di Soluzioni Corrette

### Esempio 1: Classe Astratta

**Problema**: `new self()` su classe astratta

**Soluzione**:
```php
// Metodo helper nel trait
private static function getConcreteInstance(): \Illuminate\Database\Eloquent\Model
{
    $class = static::class;
    $reflection = new \ReflectionClass($class);
    if (! $reflection->isAbstract()) {
        return new $class();
    }
    // Gestione classi astratte...
}

// Uso corretto
$instance = self::getConcreteInstance();
```

### Esempio 2: Mixed Types

**Problema**: Accesso a proprietà su `mixed`

**Soluzione**:
```php
// ✅ CORRETTO
/** @var ConcreteModel|null $model */
$model = $this->relation()->first();
if ($model === null) {
    return null;
}
$property = $model->property;
```

### Esempio 3: Binary Operations

**Problema**: Operazioni binarie su `mixed`

**Soluzione**:
```php
// ✅ CORRETTO
$value = is_string($mixed) ? $mixed : (string) $mixed;
echo 'Value: '.$value;
```

## 📚 Riferimenti

- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Modules/Sigma/docs/phpstan-level10-strategy.md](./phpstan-level10-strategy.md)
- [Modules/Xot/docs/phpstan-errors-strategy.md](../../Xot/docs/phpstan-errors-strategy.md)

## ⚠️ Memoria Permanente

Questa regola deve essere ricordata SEMPRE. Ogni volta che si vede un errore PHPStan:
- ❌ NON aggiungere `@phpstan-ignore-next-line`
- ✅ ANALIZZARE e RISOLVERE correttamente
- ✅ DOCUMENTARE la soluzione

*Ultimo aggiornamento: Gennaio 2025*

