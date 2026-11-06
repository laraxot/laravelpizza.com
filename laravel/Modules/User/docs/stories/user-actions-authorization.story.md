---
title: "User, autorizzazione delle azioni sugli utenti (password, verifica email, disattiva, ruolo super-admin)"
type: story
module: User
status: review
created: 2026-10-29
updated: 2026-10-29
tags: [bmad, authorization, policy, filament, actions, security, roles]
qmd: "user actions authorization authorize gate update delete change password verify email deactivate attach role super-admin restrictAssignableBy BaseUserPolicy filament"
related:
  - ./11.1-fix-userpolicy-authorization-bypass.story.md
  - ./dcp-285-correttezza-di-policy-utenti-reset-password-e-revoca-consensi.story.md
  - ../../app/Models/Policies/BaseUserPolicy.php
  - ../../../Employee/docs/stories/absence-request-authorization.story.md
---

# User, autorizzazione delle azioni sugli utenti

## Scopo

Chi apre la tabella utenti puo' fare solo quello che `BaseUserPolicy` gli consente. Le regole della policy c'erano gia' (un amministratore di modulo non modifica ne' cancella un super-admin, nessuno cancella se stesso); le azioni della tabella non le consultavano. Questa story le allinea, a partire dall'audit statico interno del 2026-10-29 (riservato, non riportato qui).

## Causa radice

In Filament le `Action` **non** hanno autorizzazione automatica da policy: il vendor lo dice esplicitamente ("You must explicitly use `authorize()`, `visible()`, or `hidden()`"). `XotBaseAction extends FilamentAction {}` non aggiunge nulla, quindi un'azione custom senza `authorize()` risponde a chiunque veda la riga. Vale anche per le chiamate Livewire dirette: nascondere il pulsante non basta.

Stessa famiglia del fix `AbsenceRequestPolicy` (Employee): il silenzio non e' un divieto.

## Cosa e' cambiato

| File | Modifica |
|---|---|
| `app/Filament/Actions/ChangePasswordAction.php` | `->authorize('update')` nella configurazione dell'azione (vale ovunque la si usi) e `Gate::authorize('update', $record)` come prima riga del closure, prima di scrivere la password. |
| `app/Filament/Resources/UserResource/Tables/UsersTable.php` | `deactivate`: `->authorize('delete')`, `->requiresConfirmation()` e `Gate::authorize('delete', $record)` nel closure. La semantica non cambia: continua a cancellare (soft delete), non imposta `is_active`. Label, icona e lang invariati. |
| `app/Filament/Resources/UserResource/Actions/VerifyEmailAction.php` | `->authorize('update')` e `Gate::authorize('update', $record)` nel closure. Resta il `visible()` sullo stato email. |
| `app/Models/Role.php` | `Role::SUPER_ADMIN`; `mayAssignSuperAdmin($actor)` (vero solo per un super-admin) e `restrictAssignableBy($query, $actor)` (esclude `super-admin` dalla query se l'operatore non lo e'). Un solo punto per la regola. |
| `app/Filament/Actions/Header/AttachRoleAction.php` | `recordSelectOptionsQuery()` filtra opzioni e lettura del valore ricevuto; una regola di validazione sul select rilegge l'id inviato dal server e lancia `AuthorizationException` se non e' assegnabile. Il form e' controllato dal client: la lista filtrata da sola non basta. |
| `app/Filament/Forms/Components/SingleRoleSelect.php`, `app/Filament/Tables/Columns/SingleRoleSelectColumn.php` | Condividono la stessa lista ruoli (la colonna e' la SSoT, il select la riusa) e ora passano dal filtro. Le opzioni del select si leggono al momento del render, non nel `setUp()`. |

Verdetto della policy (invariato, ora raggiunto dalle azioni): `admin` e `user::admin` agiscono sugli utenti ordinari; non su un super-admin; non cancellano se stessi. Il super-admin agisce su tutti tranne che cancellare se stesso. Chi non amministra gli utenti non cambia password e non cancella altri.

## Test

Scritti, **non eseguiti** (`.env.testing` e' MySQL con dati reali; nessun Pest in questa sessione). Pensati senza database.

- `tests/Unit/Policies/UserActionsPolicyVerdictTest.php`: matrice ruolo x abilita' (`update`, `delete`) x bersaglio (ordinario, super-admin, se stesso) con utenti Mockery, senza app.
- `tests/Unit/Models/RoleAssignableByTest.php`: `mayAssignSuperAdmin` (ospite, utente non `UserContract`, `admin`, `user::admin`, super-admin) e `restrictAssignableBy` con un builder Mockery.
- `tests/Feature/Filament/Actions/UserActionsAuthorizationTest.php`: per riflessione, le tre azioni definiscono `authorize` con l'abilita' giusta; `deactivate` chiede conferma; il `Gate::authorize` precede l'effetto nei sorgenti dei closure; `attachRole` filtra la query per un ospite e rivalida l'id. Usa l'app di test (`Tests\TestCase`, senza transazioni sul DB).

Verifica statica: `php -l` su ogni file toccato; `phpstan analyse Modules/User/app` senza errori nuovi (resta uno storico: trait inutilizzato in `Models/Traits`).

**Non verificato:** l'esecuzione dei test, il comportamento di un `Gate::authorize` dentro una chiamata Livewire reale, la tabella nel browser.

## Rischi e decisioni aperte

1. **Gerarchia dei ruoli: regola minima.** Questa story blocca solo l'assegnazione di `super-admin` a chi non lo e'. L'ordine completo dei ruoli (quale ruolo puo' assegnare quale) e' una decisione di prodotto ancora da prendere.
2. **Nome e azione di `deactivate` discordano.** Cancella, non disattiva. Trasformarla in `is_active = false` non bloccherebbe nessuno: nessun punto di login legge `is_active`. Prima va deciso se `is_active` deve valere come blocco dell'accesso, poi si cambia l'azione.
3. **`password_expires_at` non toccato.** L'azione non e' l'unico punto che imposta la password altrui (il form utente ha anche un campo password), il trait `HasPasswordExpiry` non e' usato dal modello e la colonna e' creata in modo condizionale dalle migrazioni: non si e' certi che esista. Decisione di prodotto: una password impostata da un amministratore scade subito o dopo N giorni? Se subito, va nel flusso comune (modello), non nell'azione.
4. **Perimetro.** Questa story copre le azioni `change_password`, `verify_email`, `deactivate` e l'assegnazione dei ruoli. Altre azioni custom e le azioni in blocco non sono riviste qui: il dettaglio dei punti ancora da chiudere sta nel report riservato dell'audit (repo `bashscripts`), non in questo repository pubblico.
