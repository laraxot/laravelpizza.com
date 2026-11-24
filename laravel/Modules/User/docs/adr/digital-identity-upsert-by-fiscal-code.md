---
title: "ADR — L'utente SPID/CIE si riconosce dal codice fiscale, poi dall'email verificata"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/Auth/UpsertUserFromDigitalIdentityAction.php
  - ../../app/Actions/Auth/HasVerifiedIdentityAction.php
  - ../stories/dcp-144-accesso-del-cittadino-con-spid-cie-o-decisione-motivata.story.md
  - ../contracts/upsert-user-from-digital-identity-action.md
qmd: "digital identity upsert by fiscal code"
---

# ADR: l'utente SPID/CIE si riconosce dal codice fiscale, poi dall'email verificata

## Contesto

- Le PA che chiedono identificazione informatica usano SPID e CIE (CAD art. 64 c. 2-quater e 3-bis, citati nella story
  `dcp-144`). Il modulo convive con la registrazione email + password: la stessa persona può avere già un account.
- La colonna `users.email` è unica. Un IdP SPID non sempre restituisce l'email, e CIE spesso non la verifica.
- Il codice fiscale arriva in formati diversi: SPID `TINIT-RSSMRA80A01H501U`, CIE senza prefisso.
- Domanda: con quale chiave si ritrova l'utente al secondo accesso, senza duplicati e senza consegnare l'account di altri?

## Decisione

`Modules/User/app/Actions/Auth/UpsertUserFromDigitalIdentityAction.php`:
- chiave primaria di riconoscimento = codice fiscale normalizzato (`normalizeFiscalCode()`: maiuscolo, senza `TINIT-`,
  `^[A-Z0-9]{11,16}$`, altrimenti eccezione);
- se il CF non c'è, si collega un account esistente **solo** tramite email che l'IdP dichiara verificata;
- senza email verificata il nuovo utente riceve `<metodo>.<cf>@noemail.local` con `email_verified_at` null;
- metodi ammessi solo `HasVerifiedIdentityAction::TRUSTED_IDENTITY_METHODS` (`spid`, `cie`).

## Alternative scartate

- Riconoscere per email (anche non verificata): chiunque presenti un'email altrui all'IdP prenderebbe quell'account.
- Account separato per ogni metodo di accesso: la stessa persona avrebbe due profili e la regola di unicità dell'email
  farebbe fallire l'insert quando l'email coincide.
- Lasciare `email` null per chi non la fornisce: la colonna è unica e non nulla nella migrazione owner `create_users_table`.

## Conseguenze

- Pro: un CF = un utente; chi passa da password a SPID ritrova il proprio account.
- Contro: l'indirizzo `@noemail.local` non riceve posta: le notifiche email a questi utenti non partono finché non
  aggiungono un indirizzo vero.
- Un agente non deve "semplificare" cercando prima per email: invertirebbe la garanzia.

## Verifica

`Modules/User/tests/Feature/Auth/DigitalIdentityUserUpsertTest.php` (6 casi). I casi di validazione girano verdi
(`--group=USER-SPID-UPSERT-INV-1`, `--group=USER-SPID-UPSERT-INV-2`); i 4 casi che scrivono su `users` richiedono un
database di test migrato con le colonne `fiscal_code`, `auth_method`, `identity_provider`.
