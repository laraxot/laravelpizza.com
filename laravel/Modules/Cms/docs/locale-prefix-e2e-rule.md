---
title: "locale prefix e2e rule"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "locale prefix e2e rule"
issues: []
discussions: []
---

# Locale Prefix E2E Rule

## Regola

Se una route pubblica usa il prefisso locale (`/it`, `/en`, `/de`), i test non devono limitarsi a verificare che la pagina risponda.

Devono verificare che la locale richiesta sia davvero quella attiva nel rendering.

## Esempio minimo

Per `/de` il test deve pretendere almeno:

- status corretto;
- `<html lang="de">`;
- assenza di dipendenza da `app()->getLocale()` preesistente nel test.

## Anti-pattern

Questo test e' insufficiente:

```php
$locale = app()->getLocale();
$response = $this->get('/'.$locale);
```

Perche' verifica lo stato corrente del test runner, non il comportamento del prefisso richiesto.

## Regola operativa

- testare esplicitamente `/it`, `/en`, `/de`;
- cablare il middleware che imposta la locale prima del rendering Folio;
- non delegare la risoluzione della locale a blocchi Blade sparsi.
