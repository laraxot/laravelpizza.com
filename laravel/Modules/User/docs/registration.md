---
title: "Registrazione, consensi e cancellazione account"
type: guide
module: User
tags: [registration, gdpr, consent, terms, privacy, delete-account]
qmd: "user registrazione RegisterWidget RegistrationWidget gdpr consensi privacy terms cancellazione account throttle password policy"
---

# Registrazione, consensi e cancellazione account

La registrazione ha **due widget** nel modulo User piu' una versione con consensi nel modulo Gdpr. Per login e sessione vedi
[authentication-login.md](authentication-login.md).

## `Auth\RegisterWidget` (registrazione base)

`Modules\User\Filament\Widgets\Auth\RegisterWidget` e' il widget del front office. Visibile solo agli ospiti
(`canView()` = `! Auth::check()`). Lo schema sta in `Auth\Schemas\UserForm::getRegisterFormSchema()` (unica fonte):

| Campo | Regole |
|---|---|
| `first_name`, `last_name` | obbligatori, 2-255 caratteri |
| `email` | obbligatoria, email valida, max 255, `unique(User, email)` |
| `password` | `revealable`, minimo 12 caratteri con maiuscola, minuscola, cifra e simbolo; `confirmed`; hash applicato dal campo stesso (`dehydrateStateUsing(Hash::make)`) |
| `password_confirmation` | stessa logica |

Flusso di `submit()` (e di `save()`, alias per il template del tema `wire:submit="save"`):

1. **Freno** `ConsumeAuthSubmissionSlotAction` con `AuthThrottleScope::Register` (10 invii/IP, 5/email in 600 s) *prima* di
   validare: senza, ogni invio costerebbe una query di unicita' e creerebbe utenti all'infinito.
2. `$this->form->getState()`: la password e' gia' hashata. Regole del modulo: nessun `validateForm()`, nessun `Hash::make` nel
   widget, nessuna Action che incapsula un semplice `create()`.
3. In transazione: `XotData::make()->getUserClass()::create(...)` con `name = "nome cognome"` (o l'email) e
   `email_verified_at = null`; se la tabella dell'activity log e' scrivibile (`IsActivityLogSchemaWritableAction`) registra
   l'evento `user::activity.log_registered` con IP e user agent.
4. `handleSuccessfulRegistration()`: se `config('auth.must_verify_email')` invia la mail di verifica, poi `Auth::login`, notifica di
   successo e redirect a `route('dashboard')` se esiste, altrimenti `/{locale}`.

Il middleware `EnsureRegistrationEnabled` (config `auth.registration_enabled`, default `true`) manda a una pagina CMS
con slug `register_disabled` quando la registrazione e' chiusa. Il login social registra nuovi utenti solo se la registrazione e'
abilitata (vedi [socialite-sso.md](socialite-sso.md)).

## `RegistrationWidget` (registrazione per tipo di utente)

`Modules\User\Filament\Widgets\RegistrationWidget` e' generico: dato `type`, risolve la risorsa utente con
`XotData::getUserResourceClassByType($type)`, ne usa `getFormSchemaWidget()` come schema e invoca la classe
`<Modulo>\Actions\<Modello>\RegisterAction` (derivata sostituendo `\Models\` con `\Actions\` nel nome del modello) con
`execute($record, $data)`. Al termine reindirizza alla pagina CMS `{type}_register_complete` localizzata. Se arrivano `email` e
`token` nella richiesta, il modello e' precaricato dall'utente con quel `remember_token` (utile per inviti). I flussi specifici di un
tipo di utente (per esempio una professione) vivono nel modulo che definisce quel tipo, non in User.

## Consensi GDPR

- La conformita' (consensi granulari: privacy, termini, trattamento obbligatori; marketing, profilazione, analytics, terze parti
  facoltativi; checkbox mai pre-spuntate; registro con IP, user agent e data) e' del modulo **Gdpr**:
  `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget` e `GdprConsentForm`, con le Action in `Gdpr/app/Actions/{Consent,Registration,Account}`.
  `Auth\RegisterWidget` di User dichiara di essere il fallback non-GDPR (per esempio sviluppo locale senza il modulo Gdpr).
- Widget informativi di User: `PrivacyPolicyWidget` e `TermsOfServiceWidget` (sostituiscono i vecchi componenti Livewire
  `PrivacyPolicy` e `TermsOfService`; il testo dei termini viene da `config('terms-of-service.text')`, che oggi non e' definita:
  senza config il widget non mostra testo). Il vecchio Livewire `Http\Livewire\PrivacyPolicy` resta nel codice.
- `Profile\DeleteAccountWidget` sostituisce il Livewire `Profile\DeleteAccount`.

## Cancellazione account e `deleted_at`

La cancellazione GDPR (`Modules\Gdpr\Actions\Account\DeleteAccountAction`) valorizza solo `deleted_at`: `BaseUser` non usa
`SoftDeletes` e non ha scope globale, perche' purga differita e back office devono continuare a vedere quegli utenti. Il blocco
dell'accesso sta quindi nel provider di autenticazione e nella revoca dei token: vedi la sezione "Account cancellati" di
[authentication-login.md](authentication-login.md).

## Verifica

- `tests/Playwright/auth-register-e2e.spec.js` (e2e), `tests/Feature/Auth/`, `tests/Feature/AuthPagesLocalesTest.php`.
- Traduzioni del form: `lang/<locale>/auth.php` (`register.*`), `throttle.php` (`auth_form.retry.message`); la chiave `activity.log_registered` esiste solo in `lang/en/activity.php` (in `it` manca il file: da allineare).
