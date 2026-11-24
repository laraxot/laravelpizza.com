---
title: XotBasePage, form() e vista generica
updated: 2026-11-18
qmd: "xotbasepage form and generic view vista"
---

# XotBasePage: `form()` e vista generica

Due comportamenti di `Modules\Xot\Filament\Pages\XotBasePage` aggiunti il 18/11/2026, dopo che il crawl di tutte le
pagine admin come super-admin aveva trovato 34 problemi (molti errori 500).

## 1. `form()` usa `schema()`

Le pagine Xot definiscono il form in `schema(Schema $schema)`. Filament 5 però costruisce il form principale chiamando
`form(Schema $schema)` (trait `InteractsWithForms`): se la pagina non lo ridefinisce, il form esce vuoto e la vista che
lo disegna va in errore (Cms Headernav e Footer, Xot Metatag).

`XotBasePage::form()` ora:

- chiama `schema()` se la sottoclasse lo ridefinisce;
- altrimenti tiene il comportamento di Filament (`getFormSchema()` + `getFormStatePath()`).

Le pagine non devono più usare `use InteractsWithForms` né `implements HasForms`: lo fa già la base.

## 2. Vista generica se manca quella della pagina

`getView()` cerca la vista dichiarata in `$view` o, se vuota, quella ricavata dalla classe (`GetViewByClassAction`).
Se nessuna delle due esiste, usa `xot::filament.pages.generic` invece di un errore 500. La vista generica disegna:

- i widget di intestazione e di piè di pagina della pagina;
- i form restituiti da `getGenericViewSchemas()` (gli schemi già registrati da Filament, escluso `content`).

Per una pagina di sole azioni o soli widget basta quindi `protected string $view = '';`.

## Stato del form

Con `getForms()`/`getFormSchema()` (API vecchia) lo stato finisce nelle proprietà pubbliche con il nome del campo.
Se la pagina non le dichiara, Livewire segnala `Livewire property ['campo'] cannot be found`. Due soluzioni:

- `getFormStatePath(): string { return 'data'; }`: lo stato va in `$this->data`, già dichiarato nella base;
- oppure `->statePath('data')` nello `schema()`.

Esempio corretto: `Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`.

## Test

- `Modules/Meetup/tests/Unit/Filament/Pages/MeetupDashboardTest.php` (widget della dashboard)
- crawl admin: `docs/runbook` → sezione "Verifica del back office"
