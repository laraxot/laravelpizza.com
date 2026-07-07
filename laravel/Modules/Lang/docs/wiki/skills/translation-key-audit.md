---
title: "Skill: Audit translation keys"
type: "skill"
tags: [skill, lang, translations, audit]
module: "Lang"
created: 2026-05-12
updated: 2026-05-12
---

# Skill — Audit translation keys

> Procedura on-demand per verificare che chiavi, path e ownership delle traduzioni siano coerenti tra modulo, tema e componenti Filament.

## Trigger

Usa questa skill quando:

- trovi documentazione o codice che parla di `resources/lang/`
- compaiono `->label()` o stringhe inline nei componenti Filament
- devi decidere se una traduzione appartiene al modulo o al tema

## Checklist

- [ ] confermare che il path canonico del modulo sia `lang/{locale}/...`
- [ ] cercare chiavi non semantiche o frasi inline
- [ ] verificare se la stringa appartiene al modulo owner della feature
- [ ] riallineare la documentazione a `LangServiceProvider` e alle regole root

## Procedura

### 1. Carica le regole base

Leggi:

- [translation-key-governance](../rules/translation-key-governance.md)
- [laravel12-lang-path-rule](../concepts/laravel12-lang-path-rule.md)

### 2. Cerca i due errori piu' frequenti

- path documentato come `resources/lang/...`
- label/placeholder/tooltip gestiti inline nel codice

### 3. Decidi l'ownership

- feature di business -> traduzioni nel modulo owner
- puro layout del tema -> tema
- componenti Filament di modulo -> traduzioni nel modulo

### 4. Escalation cross-module

Se la regola non e' specifica di `Lang`, collegare anche:

- [schema-conventions](../../../../../docs/wiki/rules/schema-conventions.md)
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md)

## Vedi anche

- [Rules Index](../rules/INDEX.md)
- [Lang Wiki Index](../index.md)
- [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
