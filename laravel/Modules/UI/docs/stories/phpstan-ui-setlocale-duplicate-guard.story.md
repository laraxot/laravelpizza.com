---
qmd: "ui stories phpstan ui setlocale duplicate guard story md"
title: "[STORY] PHPStan UI: guardia duplicata in SetLocale"
type: story
status: done
priority: low
created: 2026-10-08
updated: 2026-10-08
module: UI
tags: [phpstan, ui, middleware, locale, swarm]
---

# PHPStan UI: guardia duplicata in SetLocale

Fase BMAD: Dev + Docs.

## Richiesta

Azzerare gli errori PHPStan guardando lo scopo. Perimetro: `function.alreadyNarrowedType` a `SetLocale.php:30`.

## Analisi

**Scopo.** `SetLocale` sceglie la lingua: segmento URL / parametro `lang` se e' `it` o `en`, altrimenti sessione, altrimenti `app.locale`; poi `App::setLocale()` e salva in sessione.

`Session::get()` restituisce `mixed`, quindi la prima guardia `if (! is_string($locale)) { $locale = Config::string('app.locale'); }` difende un caso reale (sessione con valore non stringa; lo copre il test `SetLocale handles non-string session locale`). Il commit 4c45950 (2026-10-08) ha aggiunto la logica da URL e ha lasciato la guardia originale accanto a una nuova identica: dopo la prima `$locale` e' sempre string, la seconda e' codice morto per copia/incolla.

## Modifiche

- Rimosso il secondo blocco identico (3 righe). Comportamento invariato.

## Verifica

- `php -l`: nessun errore.
- `phpstan analyse` sul file (con gli altri 6 dello swarm `small-modules`): `[OK] No errors`.
- Pest: non eseguito (MySQL di test irraggiungibile, rc=124). `UiGapCloser100Test` (ramo sessione non stringa, che resta) e `UiHighestMissCoverageTest` coprono `SetLocale`.

## Aperto

- Un locale di sessione diverso da `it`/`en` (es. `fr`) passa senza controllo contro `app.supported_locales`; fuori perimetro.
