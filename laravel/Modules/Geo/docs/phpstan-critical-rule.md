# Regola Critica PHPStan - NON Modificare phpstan.neon

## ⚠️ ATTENZIONE: REGOLA ASSOLUTA ⚠️

Il file `../laravel/phpstan.neon` **NON DEVE MAI ESSERE MODIFICATO**.

## Principi Fondamentali

### 1. Filosofia del Progetto
- **Codice di qualità**: Il codice deve essere scritto per superare i controlli PHPStan
- **NO scorciatoie**: Non abbassare mai il livello di controllo statico
- **Miglioramento continuo**: Ogni errore PHPStan è un'opportunità per migliorare

### 2. Approccio Corretto
Quando PHPStan segnala errori:

```php
// ❌ SBAGLIATO: Modificare phpstan.neon per ignorare
// ignoreErrors:
//     - '#Call to an undefined method#'

// ✅ CORRETTO: Migliorare il codice
/**
 * @param Collection<int, User> $users
 * @return array<int, array<string, mixed>>
 */
public function processUsers(Collection $users): array
{
    return $users->map(fn (User $user): array => [
        'id' => $user->id,
        'name' => $user->name,
    ])->toArray();
}
```

### 3. Tecniche di Miglioramento

#### Type Hints Espliciti
```php
// ❌ Vago
public function getData()
{
    return $this->repository->find();
}

// ✅ Esplicito
public function getData(): ?User
{
    return $this->repository->find();
}
```

#### Generics per Collection
```php
// ❌ Non tipizzato
/** @var Collection $users */
$users = User::all();

// ✅ Tipizzato con generics
/** @var Collection<int, User> $users */
$users = User::all();
```

#### Union Types
```php
// ❌ Mixed
public function process($data)
{
    // ...
}

// ✅ Union types
public function process(string|int|null $data): void
{
    // ...
}
```

## Problemi Comuni e Soluzioni

### 1. Memory Issues con PHPStan
Se PHPStan va in crash per memoria:

```bash
# ✅ Aumentare memoria temporaneamente
php -d memory_limit=4G ./vendor/bin/phpstan analyse

# ✅ Analizzare moduli singolarmente
./vendor/bin/phpstan analyse Modules/User --level=10
./vendor/bin/phpstan analyse Modules/<nome progetto> --level=10
./vendor/bin/phpstan analyse Modules/<nome progetto> --level=10
```

### 2. File Problematici
Identificare file che causano problemi:

```bash
# Analisi con debug
./vendor/bin/phpstan analyse --debug

# Analisi con progress
./vendor/bin/phpstan analyse --verbose
```

## Benefici della Regola

1. **Qualità del codice**: Mantiene standard elevati
2. **Prevenzione bug**: Rileva errori prima della produzione
3. **Manutenibilità**: Codice più facile da mantenere
4. **Documentazione**: Type hints servono come documentazione
5. **Refactoring sicuro**: Cambiamenti più sicuri con tipi espliciti

## Collegamenti

- [Documentazione PHPStan](https://phpstan.org/user-guide)
- [Laravel PHPStan Rules](https://github.com/larastan/larastan)
- [Type Safety Best Practices](./type-safety-best-practices.md)
- [Laraxot Coding Standards](./laraxot-coding-standards.md)

## Memoria e Regole

Questa regola è documentata anche in:
- `../laravel/.ai/guidelines/phpstan-configuration-rule.md`
- `.cursor/rules/phpstan-rule.md`
- `.windsurf/rules/phpstan-rule.mdc`
- Memoria AI permanente

---

**RICORDA**: Il file `phpstan.neon` è SACRO. Non si tocca MAI. Punto.

*Ultimo aggiornamento: Gennaio 2025*

