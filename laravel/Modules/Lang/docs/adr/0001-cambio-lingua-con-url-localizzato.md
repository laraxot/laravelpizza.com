---
title: "ADR — Cambio lingua con URL localizzato"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
module: Lang
qmd: "0001 cambio lingua url localizzato"
---

# ADR: cambio lingua con URL localizzato

## Contesto

Il front office deve permettere a ospiti e utenti autenticati di cambiare
lingua senza perdere la pagina corrente. Il modulo riceve le lingue da
Laravel Localization e deve evitare URL costruiti con codici non supportati o
un cambio limitato a una preferenza di sessione.

## Driver

- Conservare la pagina equivalente nel nuovo locale.
- Usare una sola fonte per l'elenco dei locali supportati.
- Rendere il widget pubblico e non confonderlo con un editor amministrativo.

## Alternative scartate

- Salvare soltanto il locale in sessione e lasciare l'URL invariato: non
  rende esplicita la lingua nella navigazione.
- Hardcodare `it`, `en`, `de` e `es`: diverge dalla configurazione effettiva.
- Accettare qualsiasi codice passato al metodo Livewire: permette URL per
  locali non supportati.

## Decisione

`LanguageSwitcherWidget` legge `getSupportedLocales()`, costruisce gli URL con
`getLocalizedURL()` e reindirizza solo se il codice è tra quelli supportati.
Il widget è montato esplicitamente nel tema, è visibile senza autenticazione e
non è auto-scoperto come card Filament. Le impostazioni del locale restano nel
backoffice e nella pagina di configurazione dichiarata super-admin-only.

## Conseguenze

- Buono: il link mantiene la rotta equivalente e rende il locale verificabile
  nell'URL.
- Buono: nuove lingue configurate sono disponibili senza modificare il widget.
- Cattivo: una rotta equivalente o una configurazione incompleta può produrre
  fallback `/locale` o una pagina non disponibile.
- Cattivo: il widget dipende dal contratto di Laravel Localization.

## Conferma

- `app/Filament/Widgets/LanguageSwitcherWidget.php:64-120,149-154` deve
  mantenere fonte, validazione e URL localizzato.
- `tests/Unit/Filament/LanguageSwitcherWidgetTest.php` deve verificare
  discovery, locali e redirect; i test `LangHundredPercentCoverageTest.php`
  coprono cambio e fallback.
- `app/Filament/Pages/SettingPage.php:13-30` deve restare il punto delle
  impostazioni supportate/default.
