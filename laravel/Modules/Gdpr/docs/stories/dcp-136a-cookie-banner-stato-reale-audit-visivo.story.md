---
id: dcp-136a
title: "DCP-136a: stato reale del banner cookie e audit visivo"
type: story
document_type: story
category: bmad-story
epic: dc-parity-v2
status: ready-for-dev
priority: P1
owner: module:Gdpr
module: Gdpr
tags: [cookie, banner, gdpr, audit-visivo, bmad]
created: "2026-10-14"
updated: "2026-10-14"
qmd: "cookie banner stato reale middleware CookieConsentMiddleware cookie_banner_on audit visivo DCP-136 figlia"
issues: []
discussions: []
related:
  - ./dcp-136-cookie-inventario-informazione-e-guardia-sui-cookie-impostati.story.md
---

# DCP-136a: stato reale del banner cookie e audit visivo

Storia figlia di DCP-136. Perimetro: solo il modulo `Gdpr` (config, provider, lang `cookie-consent`) e la verifica visiva delle pagine pubbliche. Nessun cambio al tema.

## Richiesta

Verificare cosa l'utente vede davvero sul banner dei cookie, decidere se la storia madre è ancora valida e chiudere la discrepanza prima di intervenire su codice o inventario.

## Analisi (scopo del codice, non solo il messaggio)

- Lo scopo del banner è dare informativa e raccogliere il consenso prima di cookie non tecnici (Garante, linee guida cookie 10.6.2021, par. 7.1). Un banner inutile non protegge nessuno; uno assente quando serve viola la norma.
- `Modules/Gdpr/app/Providers/GdprServiceProvider.php` registra `Statikbe\CookieConsent\CookieConsentMiddleware` nel gruppo `web` quando `GdprData::cookie_banner_on` è `true`.
- `GdprData` (`Modules/Gdpr/app/Datas/GdprData.php:233`) ha `cookie_banner_on = true` di default.
- Il middleware del pacchetto (`vendor/statikbe/laravel-cookie-consent`) inserisce la vista `cookie-consent::index` prima di `</body>` in ogni risposta HTML, salvo `ignored_paths` (vuoto in `config/cookie-consent.php`).
- DCP-136 afferma il contrario ("nessun banner in alcuna pagina", "codice morto"). Il riferimento a `Themes/Sixteen` non è valido: il tema non esiste in `laravel/Themes/` (presenti: Meetup, Trattoria, TwentyOne, Zero).

Conclusione di analisi: la registrazione c'è ed è attiva di default. Il fatto "il banner non esce" di DCP-136 è stato osservato in un altro momento o con altro ambiente, quindi va riverificato, non assunto.

## Modifiche previste

1. Verifica HTML: richiedere le pagine pubbliche (`/it`, `/en`, `/it/auth/login`, `/it/tickets`) in ambiente locale e cercare il marker del banner (`cookie-consent-modal`) prima di `</body>`. Registrare output.
2. Verifica visiva: screenshot desktop e mobile del banner (contrasto WCAG AA, focus, pulsanti "Accetta solo i necessari" / "Accetta tutti"). Ogni difetto va annotato con file e riga.
3. Decisione: se il banner è attivo, confermare che i cookie non tecnici non vengono impostati prima del consenso; se non deve essere attivo, impostare `cookie_banner_on = false` con motivazione scritta nella storia.
4. Aggiornare DCP-136 con una nota di verifica datata (non riscrivere le sue righe, come da policy).

## Verifica

- Output reale di `curl` / screenshot allegati alla storia al momento della chiusura.
- `php -l` sui file PHP toccati, PHPStan, PHPMD, PHPInsights e Pest del modulo Gdpr, come da regole del repo.

## Decisioni aperte

- Banner attivo (con categorie) oppure solo informativa tecnica senza banner: decide il titolare. Serve la risposta prima della chiusura.

## Aperto

- `Modules/Gdpr/lang/cookie-consent` ha solo `en` e `it`; le lingue `de`, `es`, `fr`, `ru` del modulo non hanno la traduzione del pacchetto.
