---
title: "Pagine container0 index JSON-driven"
type: concept
status: active
created: 2026-10-20
updated: 2026-10-20
tags: [cms, folio, json, container0, architecture, bmad]
related:
  - ./folio-page-shell-pattern.md
  - ../../../../../Themes/Sixteen/docs/bmad/container0-index-shell-contract.md
  - ../../../../../Themes/Sixteen/docs/bmad/filament-blueprint.md
qmd: "perché `pages/{container0}/index.blade.php` non va creato cms"
---

# Perché `pages/{container0}/index.blade.php` non va creato

Per una pagina CMS di primo livello, ad esempio `/it/domande-frequenti`, la
view corretta è già:

`Themes/Sixteen/resources/views/pages/[container0]/index.blade.php`

Il parametro `container0` vale `domande-frequenti`; lo shell costruisce lo slug
`domande-frequenti.index`, `PageSlugMiddleware` prepara il contesto e `<x-page>`
risolve i blocchi dal JSON tenant.

## La view FAQ vietata

`Themes/Sixteen/resources/views/pages/domande-frequenti/index.blade.php` non deve
esistere. È una route Folio concorrente che:

1. duplica il match già coperto da `[container0]/index.blade.php`;
2. può vincere sul resolver generico in modo dipendente dalla scansione Folio;
3. bypassa il contratto JSON `pages/domande-frequenti/index.json`;
4. crea una seconda sorgente per layout, titolo, dati e manutenzione;
5. impedisce a Filament/CMS di comporre la pagina cambiando i blocchi;
6. rende i test apparentemente verdi anche quando il flusso CMS è rotto.

Il fatto che una view dedicata restituisca HTTP 200 non la rende corretta: in
questo caso nasconde proprio il difetto architetturale.

## Contratto da mantenere

```text
/it/domande-frequenti
  → [container0]/index.blade.php
  → domande-frequenti.index
  → config/.../pages/domande-frequenti/index.json
  → content-page
  → accordion source "faq"
  → ListPublishedFaqsAction
```

Le domande arrivano dall’Action del modulo Fixcity. Il tema veste il blocco
`content-page`, lo stesso delle altre pagine di contenuto. Il perché della
cartella vietata: [why-domande-frequenti-blade-php-must-not-exist.md](../../../../../Themes/Sixteen/docs/bmad/knowledge/why-domande-frequenti-blade-php-must-not-exist.md).

## Guardrail

- Il test `Themes/Sixteen/tests/Unit/FolioPageMountContractTest.php` deve fallire
  se la view vietata ricompare.
- Ogni pagina di primo livello deve usare lo shell `container0.index`; non si
  aggiungono route Folio speciali per correggere il markup di un blocco.
- Se serve una variante visuale, si modifica il blocco condiviso o una sua
  primitive, non si crea una pagina duplicata.
