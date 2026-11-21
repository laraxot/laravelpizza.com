---
type: story
slug: register-copy-project-agnostic
title: "Registrazione: testi neutri e test su cio' che il modulo possiede"
status: done
created: 2026-11-19
updated: 2026-11-19
related:
  - "../register-widget-copy-ownership.md"
  - "placeholder-translations-cleanup.story.md"
---

# Registrazione: testi neutri e test su cio' che il modulo possiede

## Contesto

`lang/*/register.php` conteneva fin dalla prima versione i testi promozionali di un altro progetto
("Start Your Pizza Journey 🍕", "Create Your FREE Account", "No credit card required - 100% FREE forever!",
vantaggi, statistiche, chiavi SEO su meetup Laravel). 32 test Gdpr fallivano: rendevano `/<lingua>/auth/register`
e cercavano quei testi, ma la pagina e' del tema ospite, che ne mostra altri. Regole violate:
`docs/wiki/rules/project-agnostic.md`, `docs/wiki/rules/module-documentation-neutrality.md`.

## Analisi (causa)

- Il `RegisterWidget` rende la vista che `XotBaseWidget::resolveView()` trova per prima: `pub_theme::` poi `gdpr::`.
  Il suo `getView()` (nome senza namespace) non veniva mai chiamato: rimosso.
- Nessun codice del monorepo legge `title`, `subtitle`, `benefits.*`, `stats.*`, `social_proof`, `clickbait.*`,
  `seo.*`: le leggevano solo i test. Erano testi di pagina, non del form.
- La vista di riserva del modulo usava `form.*` per le etichette mentre `validationAttributes()` usa
  `fields.*.label` (campo e messaggio d'errore con parole diverse) e passava `url` a `consents.privacy_policy`,
  stringa senza segnaposto: il link all'informativa spariva.
- `it/register.php` non aveva 5 chiavi presenti in en/de/es; de/es non avevano `register.submit|submitting`.
- Altri test fallivano per motivi propri: `users` cercata sulla connessione di default invece di `user`; email fissa
  `test@example.com` gia' usata da un altro test; ordinamento dei trattamenti che includeva quelli di sistema.

## Fatto

- [x] Testi neutri in it/en/de/es (e fr/ru) per `title`, `subtitle`, `submit`, `submitting`, `register.*`,
      `form.cta_*`, `success`, `success_message` (non nomina piu' le "segnalazioni" di un progetto), `error_message` (it).
- [x] Rimossi `stats`, `benefits`, `social_proof`, `clickbait`, `seo`, `sections.trust_badges`,
      `sections.benefits` e i file `lang/*/new-keys.php` (solo testi promozionali, mai letti).
- [x] `gdpr.php` en/it: sottotitolo, pulsante e `marketing_hint` neutri; refusi `(UE]`, `6(1](b]` corretti.
- [x] Stesse 80 chiavi in it/en/de/es (esclusa l'impalcatura `navigation`/`label`/`plural_label`).
- [x] Vista di riserva: etichette `fields.*.label`, consensi `*_label` + link a informativa/condizioni.
- [x] Test riscritti per cercare etichette e consensi del form, non titolo/vantaggi/link al login della pagina.
- [x] Guardia nuova `tests/Feature/RegisterWidgetContractTest.php`: contratto su vista risolta e vista di riserva
      in 4 lingue, parita' delle chiavi, nessuna parola di un progetto nei file di lingua, ogni chiave usata dal codice
      tradotta in ogni lingua.
- [x] Doc: `register-widget-copy-ownership.md`; i doc che descrivevano la vecchia copy marcati come superati.

## Verifica

- Pest (runner scratch): prima 31 falliti / 196 passati; dopo 0 falliti / 237 passati (14 skipped, 3 risky
  preesistenti: test senza asserzioni). Test Fixcity sulla registrazione: 21/21 verdi.
- PHPStan `Modules/Gdpr`: 0 errori.
- Checksum di `laravel/config` invariato prima/dopo la suite; quello di `Modules/*/lang` cambia solo per le modifiche
  volute ai file Gdpr.

## Punti aperti

- Un progetto ospite che usava le chiavi rimosse deve portarle nel proprio tema o in `lang/vendor/gdpr/`.
- FixCity, se vuole ripristinare "prima di inviare una segnalazione" nel messaggio di successo, lo sovrascrive in
  `laravel/lang/vendor/gdpr/<lingua>/register.php` (fuori dal modulo).
- `lang/it/account.php` (`account_deleted`) parla di "segnalazioni aperte": e' testo di un progetto, da valutare
  insieme all'azione di cancellazione account.
- `tests/TestCase.php` transa solo la connessione `sqlite`: sulle connessioni MySQL i dati dei test restano nel
  database (e' la causa della collisione su `test@example.com`).
- I test sulla pagina sono ripetuti in 5 file (`RegisterPage*`, `RegistrationPageTest`, `Auth/RegisterPageTest`):
  da accorpare.
