---
title: "Integrazione della cookiebar (superato)"
type: note
status: stale
stale_reason: "Superato da cookie-banner.md (DCP-153, 2026-10-14): non descrive il banner che gira. Il contenuto resta come cronologia."
superseded_by: cookie-banner.md
updated: 2026-10-14
tags: [gdpr, cookie, stale]
qmd: "cookiebar superato cookie-banner dcp-153"
---

# Cookiebar multilingua: Bootstrap Italia + Gdpr

## Scopo

La Cookiebar è il punto di informazione e scelta iniziale per i visitatori
anonimi. Mantiene il contratto UX di Bootstrap Italia (`.cookiebar`, azioni
chiare, link alle preferenze), ma non importa Bootstrap: il rendering usa
TailwindCSS, Alpine.js e DaisyUI. Lit e Flowbite restano parte dello stack
disponibile, senza introdurre codice inutile in questo componente.

La Cookiebar non sostituisce il modulo Gdpr: il modulo resta proprietario delle
informative, dei trattamenti, dei consensi autenticati, delle revoche e
dell'audit. La preferenza del visitatore anonimo è invece un cookie tecnico
gestito dal package consent.

## Runtime scelto

Il runtime unico è `statikbe/laravel-cookie-consent`, già richiesto da
`Modules/Gdpr/composer.json` e bloccato nel lockfile. `GdprServiceProvider`
registra `CookieConsentMiddleware` quando `GdprData::$cookie_banner_on` è
abilitato; il middleware inietta la view prima di `</body>` nelle risposte HTML.
La posizione visiva è fissa in fondo alla viewport, quindi non dipende dal
layout specifico e non viene duplicata nelle singole pagine.

La view pubblicata è sovrascritta qui:

```text
resources/views/vendor/cookie-consent/index.blade.php
```

e delega all'implementazione canonica del tema:

```text
Themes/Sixteen/resources/views/components/feedback/cookiebar.blade.php
```

I layout Sixteen non devono includere manualmente la Cookiebar: il middleware
è l'unico punto globale di injection.

## Contratto di consenso

La configurazione canonica è `config/cookie-consent.php`:

| Elemento | Valore |
|---|---|
| Chiave cookie | `__cookie_consent` |
| Solo necessari | `false` |
| Analytics | `2` |
| Marketing | `3` |
| Analytics + marketing | `true` |
| Durata | `365` giorni |

Il componente legge questi valori tramite `config()` e salva la scelta con
Alpine. Non introduce una seconda chiave in `localStorage` e non usa
`gdpr_cookie_consent`.

Le azioni sono:

- `Preferenze`: apre la policy/preference page localizzata del progetto;
- `Solo necessari`: salva il valore tecnico di diniego delle categorie opzionali;
- `Accetto`: salva il consenso alle categorie configurate come entrambe.

Prima della scelta il banner non abilita analytics, marketing o terze parti.
Il semplice rendering della Cookiebar non è consenso.

## Multilingua

Tutte le stringhe della Cookiebar passano da `__()` e quindi dal catalogo di
traduzioni Laravel. Il link usa `LaravelLocalization::localizeURL()` per
conservare la lingua attiva. La pagina tecnica `/{locale}/cookie-policy` espone
l'inventario minimo dei cookie tecnici e di preferenza e rimanda all'informativa
privacy. Il contenuto deve restare coerente con la lingua attiva e descrivere
almeno cookie, finalità, durata, categorie, base giuridica e modalità di revoca.

Non inserire testi hardcoded in una sola lingua e non usare URL assoluti verso
una sola versione linguistica.

## Scelta tra i package

`spatie/laravel-cookie-consent` è stato studiato ma non viene installato:
fornisce un flusso più semplice e non copre il contratto a categorie e il
diniego esplicito richiesto da questa integrazione. Aggiungerlo accanto a
Statikbe creerebbe due runtime, cookie e comportamenti concorrenti.

## Accessibilità e vincoli

- un solo landmark `region` con etichetta accessibile;
- azioni native `button` e link tastierabili;
- target touch minimo tramite classi DaisyUI/Tailwind;
- `x-cloak`, `x-show` e transizione Alpine senza Bootstrap JS;
- nessun `data-bs-*`, Bootstrap CSS o Bootstrap JS;
- la classe semantica `cookiebar` resta per compatibilità e test di contratto.

## Verifica

Da `laravel/`:

```bash
php artisan view:cache
php artisan config:clear
php artisan route:list
```

Verificare inoltre in browser, per ogni lingua pubblica, primo accesso senza
`__cookie_consent`, azioni da tastiera, persistenza, ritorno alla policy e
assenza di script/richieste opzionali prima del consenso.

Questa integrazione è una misura tecnica: non sostituisce la verifica del
titolare, dei responsabili, delle finalità effettive, dei trasferimenti e
dell'inventario reale prima della messa in produzione.

## Riferimenti

- [Bootstrap Italia Cookiebar](https://italia.github.io/bootstrap-italia/docs/componenti/cookiebar/)
- [Spatie Laravel Cookie Consent](https://github.com/spatie/laravel-cookie-consent)
- [Statikbe Laravel Cookie Consent](https://github.com/statikbe/laravel-cookie-consent)
- `Modules/Gdpr/docs/cookie-consent.md`
