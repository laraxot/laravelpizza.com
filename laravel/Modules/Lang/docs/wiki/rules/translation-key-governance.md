---
qmd: "translation key governance"
issues: []
discussions: []
title: "Translation Key Governance"
type: "rule"
tags: [translations, lang, filament, governance]
module: "Lang"
created: 2026-05-12
updated: 2026-10-22
status: draft
---

# Translation Key Governance

<!--
Harness: qmd + BMAD + agent wiki (Lang rules). Cambia comportamento agenti:
no stringhe FO hardcoded, no ->label(), owner vs pub_theme. File già
canone governance; aggiornamento FO/multilingua. User: «ricordati che il
sito e' in multilingua e le chiavi delle traduzioni seguono delle
convenzioni , fa tutto con bmad + second brain + filament blueprint».
-->

## Regola

Nel progetto Laraxot le traduzioni devono restare:

- nel modulo owner della business logic (`Modules/<Modulo>/lang/<locale>/`)
- chrome FO del tema in `Themes/<Tema>/lang/<locale>/` via `pub_theme::`
- sotto `lang/{locale}/...`, non `resources/lang/...`
- richiamate con chiavi semantiche, non con frasi inline
- presenti per `it`, `en`, `de`, `es` (fallback Laravel se manca una locale)

## Conseguenze operative

- **mai** usare frasi complete come chiavi di traduzione
- **mai** usare `->label()` come sorgente primaria delle label Filament
- **mai** stringhe UI hardcoded nei Blade FO (né italiano né altre lingue)
- le label devono essere risolte dal `LangServiceProvider` e dai file lingua
- se una funzionalita' appartiene a un modulo, la copy deve vivere nel modulo, non nel tema
- breadcrumb/nav/cta tema: `pub_theme::navigation.*` / `pub_theme::header.*.label`

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
- [schema-conventions](../../../../../../docs/wiki/rules/schema-conventions.md)
- [filament-rules-summary](../../../../../../docs/wiki/rules/filament-rules-summary.md)
- FO chrome + URL: [frontoffice-link-conventions](../../../../Fixcity/docs/frontoffice-link-conventions.md)
