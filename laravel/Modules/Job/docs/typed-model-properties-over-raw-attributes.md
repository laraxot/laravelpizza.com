---
issues: []
discussions: []
title: "Proprietà tipizzate invece di $this->attributes[...]"
module: "Job"
type: rule
status: approved
tags: [job, phpstan, eloquent, casts, mixed]
created: 2026-08-18
updated: 2026-08-18
qmd: "cast mixed to int JobBatch attributes casts proprieta tipizzate phpstan max eloquent"
related:
  - "../../Xot/docs/cast-actions.md"
  - "../../Xot/docs/safe-casting-actions.md"
---

# Proprietà tipizzate invece di `$this->attributes[...]`

> `(int) ($this->attributes['total_jobs'] ?? 0)` produce `cast.int — Cannot cast mixed to
> int` a livello max. Il cast non è la causa: la causa è aver bypassato il sistema di
> cast di Eloquent, che sul model era già configurato correttamente.

## Il caso `JobBatch`

`JobBatch` dichiarava già entrambe le cose necessarie:

```php
/** @property int $total_jobs */          // docblock del model
'total_jobs' => 'integer',                 // casts()
```

Il codice però leggeva `$this->attributes['total_jobs']`, cioè l'array grezzo degli
attributi: valore **non castato** e tipizzato `mixed`. Da lì il `(int)` diventava
obbligatorio, e a livello max `(int) mixed` è un errore.

| Prima | Dopo |
|---|---|
| `(int) ($this->attributes['total_jobs'] ?? 0)` | `$this->total_jobs` |
| `(int) ($this->attributes['pending_jobs'] ?? 0)` | `$this->pending_jobs` |
| `(int) ($this->attributes['failed_jobs'] ?? 0)` | `$this->failed_jobs` |

Il comportamento a runtime non cambia: su un model senza quell'attributo la proprietà
vale `null` e l'aritmetica PHP la tratta come `0`, esattamente come faceva `?? 0`.
L'operatore vede conteggi batch corretti: non è un esercizio PHPStan.

## Regola

1. Leggi il valore dalla **proprietà**, non da `$this->attributes[...]`. Il docblock
   `@property` e `casts()` esistono per questo.
2. `mixed` è l'ultima spiaggia. Prima di dichiararlo o di passarci attraverso, chiediti
   da dove nasce il valore: quasi sempre c'è un tipo più stretto già disponibile a monte.
3. Solo se il valore è davvero non tipizzabile alla fonte (stato di una colonna Filament,
   JSON esterno, argomenti arbitrari) usa le Action di cast del modulo Xot —
   `SafeStringCastAction`, `SafeIntCastAction` — invece di un cast inline.
4. Non aggiungere `@var` o `assert()` per zittire l'analizzatore: sposta il tipo dove il
   valore nasce.

In `ScheduleArguments::formatArrayTags()` convivono i due casi. La chiave è già
`int|string` e non va fatta passare da un'Action che accetta `mixed`; il valore arriva da
`TextColumn::getState()` ed è genuinamente non tipizzato:

```php
return (string) $key.'='.SafeStringCastAction::cast($value);
//     ^ tipo già noto        ^ mixed reale, ultima spiaggia
```

## Verifica

```bash
cd laravel && php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Job
```

## Riferimenti

- [Azioni di cast sicure (Xot)](../../Xot/docs/cast-actions.md)
- [Story 5.7 — PHPStan Modules green](../../Xot/docs/stories/5.7.phpstan-modules-green.story.md)
