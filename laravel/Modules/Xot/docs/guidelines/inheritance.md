# Regole di Ereditarietà

## Principi Fondamentali

### 1. Principio di Sostituzione di Liskov (LSP)
- Una classe figlia deve poter essere sostituita alla classe padre senza alterare il comportamento
- Non è possibile ridurre la visibilità dei metodi ereditati
- Non è possibile modificare la firma dei metodi ereditati

### 2. Contratti di Interfaccia
- Mantenere la stessa visibilità dei metodi ereditati
- Documentare esplicitamente le modifiche al comportamento
- Utilizzare PHPDoc per specificare i contratti

## Best Practices

### Visibilità dei Metodi
```php
// ❌ ERRATO
class Child extends Parent {
    protected function inheritedMethod() {} // Riduce la visibilità
}

// ✅ CORRETTO
class Child extends Parent {
    public function inheritedMethod() {} // Mantiene la visibilità
}
```

### Documentazione
```php
/**
 * @inheritdoc
 * @override
 * 
 * Modifica il comportamento originale aggiungendo X
 */
public function inheritedMethod()
{
    // Implementazione
}
```

### Controlli Automatici
- Utilizzare PHPStan per verificare la conformità
- Implementare test di unità che verificano il contratto
- Includere controlli nel CI/CD

## Esempi Comuni di Errori

### 1. Modifica della Visibilità
```php
// ❌ ERRATO
class BaseMigration extends Migration {
    protected function shouldRun() {} // Violazione LSP
}

// ✅ CORRETTO
class BaseMigration extends Migration {
    public function shouldRun() {} // Conforme
}
```

### 2. Modifica della Firma
```php
// ❌ ERRATO
class Child extends Parent {
    public function method($param) {} // Parametro mancante
}

// ✅ CORRETTO
class Child extends Parent {
    public function method($param1, $param2 = null) {} // Parametri opzionali
}
```

## Checklist di Verifica

1. [ ] La visibilità dei metodi ereditati è mantenuta o aumentata
2. [ ] La firma dei metodi è compatibile con quella della classe padre
3. [ ] Le modifiche al comportamento sono documentate
4. [ ] I test verificano la conformità al contratto
5. [ ] PHPStan non segnala violazioni LSP

## Risorse Utili
- [Documentazione PHP su Ereditarietà](https://www.php.net/manual/en/language.oop5.inheritance.php)
- [Principi SOLID](https://en.wikipedia.org/wiki/SOLID)
- [PHPStan - Analisi Static](https://phpstan.org/) 
