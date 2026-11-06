---
title: "Approfondimento: simplepleb/laravel-email-templates"
type: concept
tags: [email, templates, simplepleb]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-templates-simplepleb-1 approfondimento: simplepleb/laravel-email-templates"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: superseded
superseded_by: ../../email-templates-simplepleb.md
---

# Approfondimento: simplepleb/laravel-email-templates

**Repository:** https://github.com/simplepleb/laravel-email-templates

## Funzionalità principali
- Template email pronti (Blade, markdown)
- Installazione semplice con composer
- Preview delle email tramite route dedicate (solo dev)
- Configurazione centralizzata (config/pleb.php, lang/pleb.php)
- Supporto immagini, variabili dinamiche, multi-template

## Vantaggi
- Pronto all’uso, ideale per progetti semplici
- Preview locale utile per sviluppo
- Facile override delle stringhe via lang
- Possibilità di personalizzare header/footer

## Svantaggi
- Non gestisce template da database (solo file)
- Personalizzazione avanzata richiede override manuale
- Funzionalità limitate rispetto a soluzioni come Spatie

## Pattern utili per <nome progetto>
- Implementare preview template solo in ambiente dev
- Separare logic di configurazione (config, lang)
- Usare variabili dinamiche per link, nomi, ecc.

## Esempio di utilizzo
```php
Mail::to($user)->send(new WelcomeMember($user, $options));
```

## Raccomandazioni
- Utile per template statici, non per override runtime
- Valido come fallback statico in architettura ibrida
