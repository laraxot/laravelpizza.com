---
title: "PHPStan + Pest — pattern risolti nel modulo Notify"
type: memory
module: Notify
created: 2026-07-06
updated: 2026-07-06
tags: [phpstan, pest, testing, patterns, sms-actions]
qmd: "phpstan pest method.internalClass expect beforeEach this action scope notify sms test"
---

# PHPStan + Pest — pattern risolti (Notify)

## 1. `$this->property` in `beforeEach` — undefined property

**Errore:** `Access to an undefined property Pest\PendingCalls\TestCall::$action`

**Causa:** PHPStan vede `$this` nei closure di `beforeEach`/`it()` come
`Pest\PendingCalls\TestCall`, non come l'istanza del test. Qualsiasi
`$this->xxx = ...` in `beforeEach` risulta una property non dichiarata su
quella classe.

**Fix:** Non usare `$this->property` in `beforeEach`. Instanziare localmente
in ogni `it()`:
```php
// PRIMA (sbagliato per PHPStan)
beforeEach(function () {
    $this->action = new SendAgiletelecomSMSAction;
});
it('can be instantiated', function () {
    expect($this->action)->toBeInstanceOf(...);
});

// DOPO (corretto)
it('can be instantiated', function () {
    $action = new SendAgiletelecomSMSAction;
    /** @phpstan-ignore method.internalClass */
    expect($action)->toBeInstanceOf(SendAgiletelecomSMSAction::class);
});
```

## 2. `method.internalClass` su `expect()` — file senza namespace

**Errore:** `Call to method toBeTrue() of internal class Pest\Mixins\Expectation<TValue> from outside its root namespace Pest.`

**Causa:** File Pest senza `namespace` dichiarato sono nel namespace globale.
PHPStan non vede il bridge Pest e tratta `Expectation` come internal.

**Fix:** Aggiungere `/** @phpstan-ignore method.internalClass */` prima di
ogni riga che inizia una chain `expect()` o `it()->with()`.

Nota: i file Notify come `emailtemplatestest.php`, `jsoncomponentstest.php`,
e i test SMS sono tutti senza namespace per design — il `@phpstan-ignore`
inline è la soluzione corretta (non aggiungere namespace, non modificare
`phpstan.neon`).

## 3. `use function Safe\xxx` duplicato con `Pest.php` bootstrap

**Errore:** `Cannot use function Safe\class_uses as class_uses because the name is already in use`

**Causa:** `Modules/Notify/tests/Pest.php` importa già `use function Safe\file_get_contents`.
Se un test file aggiunge la stessa import, PHPStan processa entrambi nel
medesimo scope e vede un duplicato.

**Fix:** Usare FQCN diretto invece di import:
```php
// SBAGLIATO
use function Safe\class_uses;
$traits = class_uses($action);

// CORRETTO
$traits = \Safe\class_uses($action);
```

## 4. File SMS action tests — struttura finale corretta

I test dei file `Send*SMSActionTest.php` devono seguire questo pattern:
- No `namespace` declaration
- No `use function Safe\file_get_contents` (già in Pest.php)
- No `use function Safe\class_uses` (già in Pest.php)
- No `beforeEach` con `$this->property`
- `\Safe\file_get_contents($filename)` (FQCN)
- `\Safe\class_uses($action)` (FQCN)
- `/** @phpstan-ignore method.internalClass */` prima di ogni `expect()`
