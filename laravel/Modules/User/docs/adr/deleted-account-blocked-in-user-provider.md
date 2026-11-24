---
title: "ADR — L'account cancellato si blocca nel provider utenti, non con SoftDeletes"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/Auth/BuildActiveUserProviderAction.php
  - ../../app/Actions/Auth/RevokeUserAccessAction.php
  - ../stories/account-deletion-and-email-verification.story.md
<<<<<<< HEAD
=======
qmd: "deleted account blocked user provider laccount"
>>>>>>> laraxot/dev
---

# ADR: l'account cancellato si blocca nel provider utenti, non con SoftDeletes

## Contesto

- La cancellazione dell'account chiesta dall'interessato (`Modules/Gdpr/app/Actions/Account/DeleteAccountAction.php`)
  valorizza solo `users.deleted_at`: la purga è differita e il back office deve ancora vedere quegli utenti.
- `BaseUser` non usa `SoftDeletes` né uno scope globale. Un account cancellato però non deve più entrare: login web,
  Filament, Volt, `POST /api/user/login`, sessioni già aperte, cookie "ricordami", token Passport (SEC-05).
- Domanda: dove mettere un solo filtro che copra tutte le strade d'ingresso senza nascondere l'utente al back office?

## Decisione

- Il filtro sta nel provider: `BuildActiveUserProviderAction` costruisce un `EloquentUserProvider` con `withQuery()` che
  aggiunge `whereNull(deleted_at)`; `UserServiceProvider` lo registra al posto del driver `eloquent`, quindi vale per ogni
  tenant senza toccare i file `auth.php` del tenant.
- Il filtro si applica solo ai modelli `UserContract` che hanno la colonna (`ModelHasColumnAction`): un altro modello
  autenticabile o una tabella legacy senza `deleted_at` non si rompe.
- In più `RevokeUserAccessAction` revoca token e refresh token Passport e ruota il remember token, così il registro dei
  token resta vero anche se `deleted_at` venisse azzerato.

## Alternative scartate

- `SoftDeletes` su `BaseUser`: nasconderebbe l'utente a back office, purga differita e relazioni di tutti i moduli.
- Scope globale: stesso effetto, più difficile da escludere caso per caso.
- Controllo in ogni punto di login: almeno sei punti d'ingresso, basta dimenticarne uno.

## Conseguenze

- Pro: un solo punto, che copre anche sessioni e token già emessi alla richiesta successiva.
- Contro: chi interroga `User::query()` direttamente vede anche gli account cancellati: è voluto, ma va ricordato
  quando si contano gli utenti attivi.

## Verifica

`Modules/User/tests/Feature/Auth/DeletedAccountAccessTest.php`: i due test sul provider (`the users provider ...`) girano
verdi; quelli che creano utenti richiedono un database di test migrato (colonna `state` di `users`).
