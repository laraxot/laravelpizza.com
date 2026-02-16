# Action Usage Patterns - Regole Fondamentali

## 🎯 **REGOLA CRITICA: Pattern di Uso delle Action**

### ✅ **PATTERN CORRETTO (Dependency Injection)**
```php
// SEMPRE usare questo pattern
app(\Modules\Xot\Actions\Cast\SafeStringCastAction::class)->execute($value)
app(\Modules\Xot\Actions\Cast\SafeFloatCastAction::class)->execute($value)
app(\Modules\Xot\Actions\Geo\GetDistanceExpressionAction::class)->execute($lat, $lng, $alias)
```

### ❌ **PATTERN ERRATO (Metodi Statici)**
```php
// MAI usare questi pattern
\Modules\Xot\Actions\Cast\SafeStringCastAction::cast($value)
SafeStringCastAction::cast($value)
```

## 🧠 **MOTIVAZIONI ARCHITETTURALI**

1. **Dependency Injection**: Permette testing, mocking, e IoC container
2. **Coerenza**: Rispetta l'architettura Laraxot e Laravel
3. **Testabilità**: Facilita unit testing e mocking
4. **SOLID Principles**: Rispetta Dependency Inversion Principle
5. **Flessibilità**: Permette override e customizzazione via container

## 📋 **CHECKLIST PRE-IMPLEMENTAZIONE**

Prima di usare un'Action:
- [ ] Verificare l'implementazione dell'Action
- [ ] Controllare se ha metodi statici di convenienza
- [ ] SEMPRE usare `app(ActionClass::class)->execute()`
- [ ] MAI usare metodi statici diretti

## 🔍 **IDENTIFICAZIONE ERRORI COMUNI**

### Pattern da cercare e correggere:
```bash
# Cerca pattern errati
grep -r "::cast(" Modules/
grep -r "::execute(" Modules/
grep -r "ActionClass::" Modules/
```

### Pattern corretti da mantenere:
```bash
# Verifica pattern corretti
grep -r "app.*Action.*->execute" Modules/
```

## 📚 **ESEMPI PRATICI**

### SafeStringCastAction
```php
// ✅ CORRETTO
$result = app(\Modules\Xot\Actions\Cast\SafeStringCastAction::class)->execute($mixedValue);

// ❌ ERRATO
$result = \Modules\Xot\Actions\Cast\SafeStringCastAction::cast($mixedValue);
```

### GetDistanceExpressionAction
```php
// ✅ CORRETTO
$expression = app(\Modules\Xot\Actions\Geo\GetDistanceExpressionAction::class)->execute($lat, $lng, $alias);

// ❌ ERRATO
$expression = \Modules\Xot\Actions\Geo\GetDistanceExpressionAction::getExpression($lat, $lng, $alias);
```

## 🚨 **CONTROLLI AUTOMATICI**

### Script di Validazione
```bash
#!/bin/bash
# Cerca pattern errati nelle Action
echo "Cercando pattern errati..."
find Modules/ -name "*.php" -exec grep -l "Actions.*::" {} \;
```

### PHPStan Rules
Aggiungere regole PHPStan per identificare automaticamente questi pattern.

## 🔄 **PROCESSO DI CORREZIONE**

1. **Identificare** tutti i file con pattern errati
2. **Verificare** l'implementazione dell'Action
3. **Sostituire** con il pattern corretto
4. **Testare** che la funzionalità rimanga invariata
5. **Documentare** la correzione

## 📖 **RIFERIMENTI**

- [Laravel Service Container](https://laravel.com/project_docs/container)
- [Dependency Injection Patterns](https://laravel.com/project_docs/providers)
- [Spatie QueueableAction](https://github.com/spatie/laravel-queueable-action)

---

**PRIORITÀ**: CRITICA - Da seguire SEMPRE senza eccezioni
**AGGIORNATO**: 2025-01-30
**AUTORE**: Sistema di Qualità Laraxot
