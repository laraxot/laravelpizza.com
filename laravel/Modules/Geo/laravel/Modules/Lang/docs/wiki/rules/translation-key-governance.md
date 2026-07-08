---
title: "Translation Key Governance"
type: "rule"
tags: [translations, lang, filament, governance]
module: "Lang"
created: 2026-05-12
updated: 2026-05-12
---

# Translation Key Governance

## Regola

Nel progetto Laraxot le traduzioni devono restare:

- nel modulo owner della business logic
- sotto `lang/{locale}/...`, non `resources/lang/...`
- richiamate con chiavi semantiche, non con frasi inline

## Conseguenze operative

- **mai** usare frasi complete come chiavi di traduzione
- **mai** usare `->label()` come sorgente primaria delle label Filament
- le label devono essere risolte dal `LangServiceProvider` e dai file lingua
- se una funzionalita' appartiene a un modulo, la copy deve vivere nel modulo, non nel tema

## Pattern minimo corretto

```text
module::context.collection.element.type
```

Esempi:

- `user::auth.login.form.email.label`
- `user::auth.login.form.password.placeholder`
- `lang::translations.audit.summary.label`

## Path canonico

Per i moduli il path valido resta:

```text
laravel/Modules/<Module>/lang/<locale>/...
```

Non documentare come standard:

```text
laravel/Modules/<Module>/resources/lang/...
```

## Filament

Nei componenti Filament:

- evitare `->label()`, `->placeholder()`, `->tooltip()` hardcoded
- preferire chiavi modulo e risoluzione automatica via `LangServiceProvider`

## Vedi anche

- [laravel12-lang-path-rule](../concepts/laravel12-lang-path-rule.md)
- [schema-conventions](../../../../../docs/wiki/rules/schema-conventions.md)
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md)
