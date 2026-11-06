# Pagine auth e segnalazioni in tutte le lingue (it, en, de, es)

- Stato: done (2026-10-07)
- Fase BMAD: Quick Flow (audit sistematico, fix, test di regressione)
- Owner: Modules/User (lang auth), Modules/Fixcity (lang ticket/global), tema Sixteen (lang navigation, view logout)

## Problema

`/en/auth/login` era in italiano. Causa strutturale: `fallback_locale = it`, quindi una chiave mancante in en/de/es mostra l'italiano
senza errori. Il difetto riguardava tutte le lingue e piu' pagine.

## Metodo

`bashscripts/tools/i18n/audit-locales.py` (vedi `bashscripts/docs/i18n-locale-audit.md`): per ogni pagina e lingua confronta le righe
visibili con la stessa pagina in italiano (identiche = non tradotte) e cerca chiavi grezze `ns::gruppo.chiave`.

## Trovato e corretto

- `/auth/password/reset`: chiavi grezze `user::login.password_reset_page.*` in TUTTE le lingue, italiano incluso. Aggiunte in 4 lingue.
- de: `login.php` e `user_form.php` erano segnaposto (etichette = nome del campo). Riscritti. es: `user_form.php` assente, creato.
- Pagina logout: testo italiano cablato, e **bug latente**: componente Volt anonimo in pagina Folio senza `@volt` funzionava solo
  grazie alla vista compilata in cache; `view:clear` (eseguito dalla build del tema) lo faceva diventare 500. Aggiunto `@volt('auth.logout')`.
- Regola password: la validazione richiede anche una minuscola (`regex:/[a-z]/`) ma l'aiuto sotto il campo non la citava. Corretto in tutte le lingue.
- Pagina segnalazioni de/es: 15 chiavi `fixcity::ticket.*` (titoli, filtri, contatti, CTA).
- Footer e finestra di ricerca de/es: `pub_theme::navigation.homepage.*` (35 chiavi), `fixcity::global.related_title`,
  `fixcity::global.breadcrumb` (aria-label cablato in 8 template).
- Refuso it: "Valuta 1 stelle su 5" -> "1 stella".

## Verifica

- `LoginPageTranslationsTest.php`: 31 chiavi x 4 lingue = 124 test, senza DB.
- Audit a pagina intera pulito su `/auth/login`, `/auth/register`, `/auth/password/reset`, `/auth/logout`, `/tickets`, home.

## Aperto

- Il resto del modulo Fixcity (wizard di segnalazione, notifiche, enum) ha ancora poche chiavi in de/es: lanciare l'audit sulle altre pagine.
- Il logout dagli header faceva POST su una rotta Folio solo GET (405): rotta POST aggiunta da un'altra sessione in `Modules/User/routes/web.php`;
  senza CSRF risponde 419 (atteso). Prova end-to-end con utente di test ancora da fare.
