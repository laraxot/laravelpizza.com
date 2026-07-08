# Naming Convention per Modelli in Laraxot PTVX

## Principio Fondamentale

I nomi dei modelli Eloquent **DEVONO** essere al singolare, mai al plurale.

### Perché

In Laravel/Eloquent, un modello rappresenta una singola entità/record. La convenzione framework richiede:
- **Modello**: Nome singolare (`User`, `Post`, `Scheda`)
- **Tabella**: Nome plurale (`users`, `posts`, `schede`)

### Esempio Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

// ✅ CORRETTO - Nome al singolare
class Scheda extends BaseModel
{
    protected $table = 'schede'; // tabella rimane plurale
}
```

### Anti-Pattern (Vietato)

```php
<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

// ❌ ERRATO - Nome al plurale
class Schede extends BaseModel
{
    // ...
}
```

## Regole Specifiche per Laraxot

### 1. Nomi in Italiano
Quando si usano termini italiani:
- Singolare: `Scheda`, `Bando`, `Dichiarazione`
- Plurale (solo per tabelle): `schede`, `bandi`, `dichiarazioni`

### 2. Convenzioni File
- **File modello**: `Scheda.php` (PascalCase, singolare)
- **File factory**: `SchedaFactory.php` (PascalCase, suffisso Factory)
- **File policy**: `SchedaPolicy.php` (PascalCase, suffisso Policy)

### 3. Relazioni nei Modelli
Nei PHPDoc delle relazioni, usare il nome singolare:

```php
/**
 * @property Collection<int, Scheda> $avversari
 * @property Scheda|null $schedaParent
 */
```

## Checklist per Nuovi Modelli

- [ ] Nome file al singolare (`Scheda.php`)
- [ ] Nome classe al singolare (`class Scheda`)
- [ ] Tabella database al plurale (`schede`)
- [ ] Factory con nome corretto (`SchedaFactory`)
- [ ] Policy con nome corretto (`SchedaPolicy`)
- [ ] PHPDoc con riferimenti corretti (`Scheda`)

## Collegamenti

- [Laravel Naming Conventions](https://laravel.com/docs/eloquent#eloquent-model-conventions)
- [Module Development Guide](./module-development.md)
- [PHPStan Level 10 Compliance](./phpstan-level10.md)

---

**Ultimo aggiornamento**: 2026-03-10  
**Autore**: Cascade AI Agent
**Modulo**: Progressioni (esempio refactor Schede → Scheda)
