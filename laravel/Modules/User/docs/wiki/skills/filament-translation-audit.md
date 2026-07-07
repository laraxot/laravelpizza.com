---
title: "Skill: Audit traduzioni Filament User"
type: "skill"
tags: [skill, user, filament, translations, langserviceprovider]
module: "User"
created: 2026-05-12
updated: 2026-05-12
---

# Skill — Audit traduzioni Filament User

> Procedura on-demand per verificare che le UI Filament del modulo `User` rispettino ownership delle traduzioni e regole XotBase.

## Trigger

Usa questa skill quando:

- tocchi page, resource o widget Filament del modulo `User`
- trovi `->label()`, `->placeholder()`, `->tooltip()` o testi inline sospetti
- devi capire se una stringa appartiene al tema o al modulo

## Checklist

- [ ] cercare `->label(`, `->placeholder(`, `->helperText(` e `->tooltip(` nei file toccati
- [ ] confermare che le traduzioni vivano nel modulo `User`, non nel tema
- [ ] verificare che le chiavi seguano la struttura `user::context.collection.element.type`
- [ ] controllare se la page/resource deve estendere classi `XotBase*`
- [ ] aggiornare log wiki modulo/root se la regola riusabile viene raffinata

## Procedura

### 1. Cerca override vietati

```bash
qmd search "User no filament labels langserviceprovider" --limit 5
```

Poi leggi:

- [no-filament-labels](../rules/no-filament-labels.md)
- [filament-langserviceprovider-governance](../concepts/filament-langserviceprovider-governance.md)

### 2. Verifica la struttura delle chiavi

Le stringhe del modulo devono convergere su chiavi tipo:

```text
user::auth.login.form.email.label
```

Riferimento:

- [translation-5-level-structure](../concepts/translation-5-level-structure.md)

### 3. Decidi l'ownership della copy

- se la stringa descrive comportamento/validazione/auth, appartiene al modulo `User`
- se la stringa e' puro layout o decorazione visuale, puo' stare nel tema
- se il componente e' Filament del modulo, preferire comunque il modulo come source of truth

### 4. Riallinea le classi base

Se il task tocca page/resource Filament, carica anche:

- [filament-page-creation](../../../../Xot/docs/wiki/skills/filament-page-creation.md)
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md)

## Vedi anche

- [Rules Index](../rules/INDEX.md)
- [User Wiki Index](../index.md)
- [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
