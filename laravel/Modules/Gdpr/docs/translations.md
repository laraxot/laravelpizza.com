---
title: "Traduzioni del modulo Gdpr"
type: reference
module: Gdpr
updated: 2026-11-25
---

# Traduzioni

Il modulo usa il namespace `gdpr::` (caricato da `XotBaseServiceProvider`) e il namespace separato `cookie-consent::` (caricato dal
provider, vedi [cookie-banner.md](cookie-banner.md)). Le regole generali (chiavi con prefisso del modulo, mai testo cablato
nell'interfaccia) sono quelle del modulo Lang.

## Cosa c'e' in `lang/`

| Lingua | File |
|---|---|
| `it` (completa) | `account`, `admin_panel_provider`, `consent`, `consents`, `event`, `events`, `gdpr`, `inject_cookie_banner`, `profile`, `profiles`, `register`, `register_widget`, `setting`, `texts`, `treatment`, `treatment_form`, `treatments`, `it.json` |
| `en` | `account`, `consent`, `event`, `gdpr`, `profile`, `register`, `register_widget`, `setting`, `texts`, `treatment`, `en.json` |
| `de` | `account`, `consent`, `event`, `gdpr`, `profile`, `register`, `texts`, `treatment` |
| `es` | `account`, `register` |
| `fr`, `ru` | solo `register` |
| `cookie-consent/{it,en,de,es}` | `texts.php`: testi del banner e della cookie policy |

`register.php` e' presente in sei lingue; il confronto delle chiavi e' fatto per `it`, `en`, `de`, `es`.

## Regole

- **Testi neutri**: nessuna frase del modulo nomina un prodotto, una comunita', un prezzo o un servizio di un progetto.
  Un progetto che vuole un testo diverso lo sovrascrive in `laravel/lang/vendor/gdpr/<lingua>/register.php`, senza toccare il
  modulo. Titoli, sottotitoli, vantaggi e meta SEO della pagina di registrazione sono del tema ospite
  ([register-widget-copy-ownership.md](register-widget-copy-ownership.md)).
- **Stesse chiavi in tutte le lingue servite**; ogni chiave letterale usata dal codice del modulo deve esistere in ogni lingua
  (guardia `tests/Feature/RegisterWidgetContractTest.php`). Le voci di impalcatura `navigation`, `label`, `plural_label` restano
  escluse dal confronto.
- **Niente chiavi segnaposto** (valore uguale alla chiave) nei file di lingua: tolte con la story `placeholder-translations-cleanup`.
- **Cookie policy**: i testi di `cookie-consent/<lingua>/texts.php` descrivono il comportamento reale (cookie tecnici elencati da
  `GetCookieInventoryAction`, terze parti dietro proxy); se il comportamento cambia, cambiano insieme.
- Le etichette dei consensi e dei campi della registrazione vivono in `gdpr::register.fields.<campo>.label` e
  `gdpr::register.consents.*` (`privacy_policy_label`, `terms_label`, `marketing_label`, `*_link`, `*_required`, `opens_new_tab`).
- Il pulsante di invio non e' parte del contratto con il tema: `gdpr::register.form.submit` e' il valore di riserva.
- Ogni enum con etichette (`ConsentType`) richiede una chiave di traduzione per caso.

## Rimossi (non reintrodurre nel modulo)

`stats.*`, `benefits.*`, `social_proof`, `clickbait.*`, `seo.*`, `sections.trust_badges`, `sections.benefits` di `register.php` e
tutti i file `lang/*/new-keys.php` (2026-11-19: descrivevano un altro prodotto e nessun codice li leggeva). Un tema che li usava
li porta nelle proprie traduzioni.
