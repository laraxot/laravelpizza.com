---
created: 2026-09-26
updated: 2026-09-26
qmd: "navigation translations current"
issues: []
discussions: []
title: "Regola corrente per le traduzioni di navigazione"
type: rule
module: Lang
status: active
tags: [filament, translations, navigation]
---

# Regola corrente per le traduzioni di navigazione

La chiave `navigation` è corretta; non sono corretti i suoi valori placeholder
come `resource.navigation`. Filament deve ricevere testi localizzati e icone
reali:

```php
'navigation' => [
    'label' => 'Prenotazioni',
    'group' => 'Sala',
    'icon' => 'heroicon-o-calendar-days',
    'sort' => 20,
],
```

L'audit si limita ai cataloghi, evitando documentazione e dipendenze:

```bash
rg -n '\\.navigation' laravel/Modules/*/lang laravel/Themes/*/lang
```

Le occorrenze nei metadati (`key`, `description`, `context`) non sono valori
visualizzati e vanno valutate separatamente. I valori `label`, `group` e
`icon` invece devono essere corretti; `sort` deve rimanere numerico.
