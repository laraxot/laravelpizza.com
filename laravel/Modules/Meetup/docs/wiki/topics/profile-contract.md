---
title: "Topic profile-contract"
type: digest
status: active
qmd: "digest ceiling 100 profile-contract"
---

# Topic profile-contract

Sintesi automatica di 3 documenti (chiave `profile-contract`).

## Meetup: Profile Contract In DocBlocks

_Fonte: `profile-contract-docblocks.md`_

# Meetup: Profile Contract In DocBlocks

## Regola

Nei PHPDoc dei model `Meetup`, le relazioni trasversali come `creator`, `updater`, `deleter` devono usare:

`@property-read \Modules\Xot\Contracts\ProfileContract|null ...`

e non:

`@property-read \Modules\Meetup\Models\Profile|null ...`

## Perche'

- il codice dipende dal contratto, non dall'implementazione concreta;
- ide-helper puo' generare un tipo troppo stretto;
- il contratto mantiene stabile il significato anche se cambia il model concreto risolto a runtime.

## Meetup Profile Contract PHPDoc Governance

_Fonte: `profile-contract-phpdoc-governance.md`_

# Meetup Profile Contract PHPDoc Governance

Nel modulo Meetup le relazioni audit/profile esposte nei PHPDoc dei model non devono dipendere da `Modules\Meetup\Models\Profile`.

Per campi come:
- `$creator`
- `$updater`
- `$deleter`

il tipo corretto e':

```php
\Modules\Xot\Contracts\ProfileContract|null
```

Questo mantiene i model Meetup allineati al contratto architetturale condiviso e impedisce che una wave `ide-helper` restringa i tipi a una implementazione concreta locale.

## Meetup: audit relation PHPDoc must use ProfileContract

_Fonte: `profile-contract-phpdoc-rule.md`_

# Meetup: audit relation PHPDoc must use ProfileContract

## Regola locale

Nel modulo `Meetup`, i PHPDoc di `creator`, `updater` e `deleter` non devono referenziare `Modules\Meetup\Models\Profile`.

Il tipo corretto e':

```php
\Modules\Xot\Contracts\ProfileContract|null
```

## Perche'

- `Meetup` consuma un profilo di dominio condiviso;
- il dettaglio implementativo del profilo puo' cambiare;
- il contratto condiviso mantiene il modulo piu' DRY, KISS e riusabile.
