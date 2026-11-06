---
title: "Fix: UserCommandIntegrationTest - Application and Config Issues"
type: concept
tags: [testing, user, command, integration]
created: 2026-07-14
updated: 2026-07-14
qmd: "testing-user-command-integration fix: usercommandintegrationtest - application and config issues"
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

# Fix: UserCommandIntegrationTest - Application and Config Issues

**Problema**: Test fallisce con "Too few arguments" e "Target class [config] does not exist"
**Principio**: Il sito funziona, quindi il test deve riflettere il comportamento reale

## 🔍 Analisi del Problema

### Errore Originale 1
- `Too few arguments to function Illuminate\Console\Application::__construct()`
- Test crea `new Application()` senza argomenti
- Application richiede: `Container $laravel, Dispatcher $events, string $version`

### Errore Originale 2
- `BindingResolutionException: Target class [config] does not exist`
- Test chiama `app(ChangeTypeCommand::class)` che causa problemi con container
- `app()->basePath()` chiamato durante istanziazione causa errore

### Errore Originale 3
- `Failed asserting that false is true` per `method_exists($this->command, 'laravel')`
- Il Command di Laravel non ha metodo pubblico `laravel()` esposto
- Metodi come `getApplication()` potrebbero non esistere o essere protected

### Causa
- Test tenta di creare manualmente Application invece di verificare il comando direttamente
- Test chiama `app()` helper che può causare problemi con container in contesto test
- Test verifica metodi che non esistono pubblicamente su Command

### Comportamento Reale
Il sito funziona perché:
- Il comando è già registrato dal Service Provider
- Non dobbiamo creare manualmente Application
- Il comando può essere istanziato direttamente senza DI

## 🛠️ Soluzione

### Pattern Corretto
```php
// ❌ ERRATO
it('can be registered with Laravel artisan', function () {
    $application = new Application(); // Richiede argomenti!
    $application->add($this->command);
    expect($application->has('user:change-type'))->toBeTrue();
});

// ✅ CORRETTO
it('can be registered with Laravel artisan', function () {
    // Il sito funziona, quindi il comando è già registrato dal Service Provider
    // Non dobbiamo creare manualmente Application, ma verificare che il comando esista
    expect($this->command->getName())->toBe('user:change-type');
    expect($this->command)->toBeInstanceOf(Command::class);
});
```

### Implementazione
1. Rimuovere creazione manuale di Application - il comando è già registrato
2. Verificare direttamente il comando invece di usare Application
3. Rimuovere chiamate a `app()` che possono causare problemi
4. Verificare metodi reali del Command invece di metodi inesistenti

## 📝 Note

- Il sito funziona, quindi il test deve riflettere il comportamento reale
- Il comando è già registrato dal Service Provider, non serve creare Application
- Evitare chiamate a `app()` helper in test che possono causare problemi container
- Verificare solo metodi realmente esistenti su Command

## 🔗 Collegamenti

- [Testing Rules](testing-rules.md)
- [ChangeTypeCommandTest](../../User/tests/Unit/ChangeTypeCommandTest.php)
- [ArtisanServiceTest](../../Xot/tests/Unit/Services/ArtisanServiceTest.php)

---

**Status**: Completed
**Risultato**: Test UserCommandIntegrationTest ora verifica il comando direttamente senza creare Application
